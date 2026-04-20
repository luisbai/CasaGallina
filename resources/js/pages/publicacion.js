class PublicacionIndex {
	constructor() {
		// Prevent multiple initializations
		if (window.publicacionIndexInitialized) return;
		
		if ($('#publicacion-index').length > 0) {
			this.pendingAction = null;
			this.pendingActionData = null;
			this.formSubmitted = false;
			this.isSubmitting = false;
			this.init();
			window.publicacionIndexInitialized = true;
		}
	}

	init () {

		// Listen for our unique preview event
		$('[data-new-action="preview-publication"]').off('click').on('click', (e) => {
            e.preventDefault();

            let $button = $(e.currentTarget);
            let data = $button.data();

            if (this.formSubmitted) {
                this.executePreview(data);
            } else {
                this.pendingAction = 'preview';
                this.pendingActionData = {
                    ...data,
                    target: $button[0]
                };
                this.showFormModal('preview');
            }
        });

        // Download button handler
        $('[data-action="descargar-publicacion"]').off('click').on('click', (e) => {
            e.preventDefault();

            let $button = $(e.currentTarget);
            let data = $button.data();
            let downloadUrl = $button.attr('href');

            if (this.formSubmitted) {
                this.executeDownload({
                    ...data,
                    target: $button[0],
                    downloadUrl: downloadUrl
                });
            } else {
                this.pendingAction = 'download';
                this.pendingActionData = {
                    ...data,
                    target: $button[0],
                    downloadUrl: downloadUrl
                };
                this.showFormModal('download');
            }
        });

        // Form validation and submission
        const self = this;
        
        // Use jQuery to intercept submit BEFORE validate takes over
        // This prevents the native browser POST submission
        const $form = $('.datos-descarga-form');
        
        $form.on('submit', function(e) {
            e.preventDefault();
            return false;
        });

        $form.validate({
            // Disable the default submit behavior of jQuery Validate
            // We handle everything manually via the submitHandler
            submitHandler: function(form, event) {
                if (event) {
                    event.preventDefault();
                }

                if (self.isSubmitting) return false;
                
                let $formEl = $(form);
                let $submitBtn = $formEl.find('button[type="submit"]');
                let originalBtnText = $submitBtn.text();
                
                self.isSubmitting = true;
                $submitBtn.prop('disabled', true).text(
                    window.location.pathname.startsWith('/en/') ? 'Sending...' : 'Enviando...'
                );

                let formData = new FormData(form);
                formData.append('intended_action', self.pendingAction);

                window.axios.post($formEl.attr('action'), formData)
                    .then((response) => {
                        if (response.data.success) {
                            $formEl.hide();
                            $('.formulario-gracias').show();

                            self.formSubmitted = true;

                            // Update pending action data with server response if available
                            if (response.data.download_url) {
                                self.pendingActionData.downloadUrl = response.data.download_url;
                            }
                            if (response.data.viewer_url) {
                                self.pendingActionData.publicacionUrl = response.data.viewer_url;
                            }

                            // Execute the intended action immediately and hide modal
                            setTimeout(() => {
                                self.executePendingAction();
                                $('#modal-datos-descarga').modal('hide');
                                self.isSubmitting = false;
                                $submitBtn.prop('disabled', false).text(originalBtnText);
                            }, 2000);
                        } else {
                            throw new Error(response.data.message || 'Submission failed');
                        }
                    })
                    .catch((error) => {
                        console.error('Form submission failed:', error);
                        self.isSubmitting = false;
                        $submitBtn.prop('disabled', false).text(originalBtnText);
                        
                        // Error is now only logged to console as requested
                    });

                return false; // Prevent default form submission
            }
        });

        // Override: when submit button is clicked, trigger validation manually
        $form.find('button[type="submit"]').on('click', function(e) {
            e.preventDefault();
            // This triggers jQuery Validate's validation + submitHandler
            $form.submit();
        });

        // Reset form when modal is hidden (but only if form wasn't just submitted)
        $('#modal-datos-descarga').off('hidden.bs.modal').on('hidden.bs.modal', () => {
            if (!this.formSubmitted) {
                $('.datos-descarga-form').show();
                $('.formulario-gracias').hide();
                $('.datos-descarga-form')[0].reset();
            }
        });
	}

    resetFormState() {
        this.formSubmitted = false;
        $('.datos-descarga-form').show();
        $('.formulario-gracias').hide();
        if ($('.datos-descarga-form').length > 0) {
            $('.datos-descarga-form')[0].reset();
        }
    }

	showFormModal(action) {
        if (this.formSubmitted) {
            this.resetFormState();
        }

        const isEnglish = window.location.pathname.startsWith('/en/');

        let title;
        if (isEnglish) {
            title = action === 'preview'
                ? 'Complete the form to preview'
                : 'Complete the form to download';
        } else {
            title = action === 'preview'
                ? 'Completa el formulario para previsualizar'
                : 'Completa el formulario para descargar';
        }

        $('#form-action-message').text(title);
        $('#modal-datos-descarga').modal('show');
    }

    executePendingAction() {
        if (this.pendingAction === 'preview') {
            this.executePreview(this.pendingActionData);
        } else if (this.pendingAction === 'download') {
            this.executeDownload(this.pendingActionData);
        }

        this.pendingAction = null;
        this.pendingActionData = null;
    }

    executePreview(data) {
        if (!data || !data.publicacionUrl) return;
        
        $('#publicacion-brochure-wrapper').html(`
            <iframe width='100%' height='700' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='${data.publicacionUrl}' style=""></iframe>
        `);
        $('#modal-publicacion').modal('show');
    }

    executeDownload(data) {
        if (!data) return;
        const downloadUrl = data.downloadUrl || $(data.target).attr('href');
        if (downloadUrl) {
            window.location.href = downloadUrl;
        }
    }

}

new PublicacionIndex();