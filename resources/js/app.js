/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import 'jquery-validation';
import './bootstrap';
import Quill from 'quill';
window.Quill = Quill;

import 'datatables';
import 'datatables.net-bs4';
import 'slick-carousel';
import 'tempusdominus-bootstrap-4';
import $ from "jquery";

import './components/donacion';
import './components/navigation';

import './pages/home';
import './pages/casa';
import './pages/estrategia';
import './pages/boletines';
import './pages/estrategias';
import './pages/aviso-privacidad';
import './pages/publicacion';
import './pages/donaciones';

import './pages/admin/estrategias/index';
import './pages/admin/estrategias/edit';
import './pages/admin/estrategias/create';

import './pages/admin/espacios/index';

import './pages/admin/miembros/index';
import './pages/admin/miembros/edit';

import './pages/admin/boletines/index';
import './pages/admin/boletines/edit';

import './pages/admin/publicaciones/index';
import './pages/admin/publicaciones/edit';

// Search functionality
document.addEventListener('DOMContentLoaded', function () {
    const searchToggle = document.getElementById('search-toggle');
    const searchForm = document.getElementById('search-form');
    const searchInput = document.querySelector('.search-input');

    if (searchToggle && searchForm) {
        // Toggle search form visibility
        searchToggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            if (searchForm.classList.contains('hidden')) {
                searchForm.classList.remove('hidden');
                searchInput?.focus();
                // Add active state to button
                searchToggle.style.backgroundColor = '#68945c';
                searchToggle.style.color = '#fff';
            } else {
                searchForm.classList.add('hidden');
                // Remove active state from button
                searchToggle.style.backgroundColor = 'transparent';
                searchToggle.style.color = '#68945c';
            }
        });

        // Close search form when clicking outside
        document.addEventListener('click', function (e) {
            if (!searchToggle.contains(e.target) && !searchForm.contains(e.target)) {
                searchForm.classList.add('hidden');
                searchToggle.style.backgroundColor = 'transparent';
                searchToggle.style.color = '#68945c';
            }
        });

        // Prevent form from closing when clicking inside
        searchForm.addEventListener('click', function (e) {
            e.stopPropagation();
        });

        // Handle hover effects
        searchToggle.addEventListener('mouseenter', function () {
            if (searchForm.classList.contains('hidden')) {
                this.style.backgroundColor = '#f0f4fa';
            }
        });

        searchToggle.addEventListener('mouseleave', function () {
            if (searchForm.classList.contains('hidden')) {
                this.style.backgroundColor = 'transparent';
            }
        });

        // Handle submit button hover
        const searchSubmit = document.querySelector('.search-submit');
        if (searchSubmit) {
            searchSubmit.addEventListener('mouseenter', function () {
                this.style.backgroundColor = '#5d8452';
            });

            searchSubmit.addEventListener('mouseleave', function () {
                this.style.backgroundColor = '#68945c';
            });
        }
    }
});

