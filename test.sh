#!/bin/bash

# Configuración del servidor de producción
SSH_KEY="~/.ssh/casagallina"
REMOTE_USER="kasper"
REMOTE_HOST="137.184.90.226"
REMOTE_PATH="/var/www/laravel"
TEMP_REMOTE_DIR="~/deploy_temp"

echo "----------------------------------------------------------"
echo "🚀 Iniciando despliegue a producción (Modo Interactivo)"
echo "Servidor: $REMOTE_HOST"
echo "Usuario: $REMOTE_USER"
echo "----------------------------------------------------------"

FILE_LIST=".deploy_list.txt"

# 1. Obtener lista de archivos modificados y nuevos (solo los que existen)
git ls-files -m -o --exclude-standard | while read -r file; do
    if [ -f "$file" ] && [[ "$file" != "copy_prod.sh" ]] && [[ "$file" != "$FILE_LIST" ]]; then
        echo "$file"
    fi
done > "$FILE_LIST"

COUNT=$(wc -l < "$FILE_LIST" | xargs)

if [ "$COUNT" -eq 0 ]; then
    echo "⚠️ No hay archivos modificados para subir."
    rm -f "$FILE_LIST"
    exit 0
fi

echo "📦 Archivos detectados ($COUNT):"
cat "$FILE_LIST" | sed 's/^/  [LISTO] /'
echo "----------------------------------------------------------"

# 2. Crear carpeta temporal en el servidor (sin sudo)
echo "📁 Creando carpeta temporal en el servidor..."
ssh -i "$SSH_KEY" "$REMOTE_USER@$REMOTE_HOST" "mkdir -p $TEMP_REMOTE_DIR"

# 3. Sincronizar archivos a la carpeta temporal (sin sudo)
echo "📤 Subiendo archivos a $TEMP_REMOTE_DIR..."
rsync -avz -e "ssh -i $SSH_KEY" --files-from="$FILE_LIST" . "$REMOTE_USER@$REMOTE_HOST:$TEMP_REMOTE_DIR/"

if [ $? -ne 0 ]; then
    echo "❌ Error al subir archivos."
    exit 1
fi

echo "----------------------------------------------------------"
echo "🔐 Moviendo archivos a producción (Requiere sudo)"
echo "Por favor, introduce tu contraseña si se solicita:"
echo "----------------------------------------------------------"

# 4. Mover de temporal a producción usando sudo (con -t para interactividad)
ssh -i "$SSH_KEY" -t "$REMOTE_USER@$REMOTE_HOST" "sudo rsync -av $TEMP_REMOTE_DIR/ $REMOTE_PATH/ && rm -rf $TEMP_REMOTE_DIR"

if [ $? -eq 0 ]; then
    echo "----------------------------------------------------------"
    echo "✅ ¡Despliegue completado con éxito!"
else
    echo "----------------------------------------------------------"
    echo "❌ Hubo un error al mover los archivos a la carpeta final."
fi

# Limpieza local
rm -f "$FILE_LIST"
echo "----------------------------------------------------------"
