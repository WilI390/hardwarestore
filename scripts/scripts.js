// scripts/scripts.js

document.addEventListener('DOMContentLoaded', () => {
    
    const cotizacionForm = document.getElementById('cotizacion-form');
    const cotizacionMensaje = document.getElementById('cotizacion-mensaje');

    if (cotizacionForm) {
        cotizacionForm.addEventListener('submit', (e) => {
            e.preventDefault();

            
            

            cotizacionMensaje.textContent = '¡Cotización solicitada con éxito!';
            cotizacionForm.reset();

            // Ocultar el mensaje después de unos segundos
            setTimeout(() => {
                cotizacionMensaje.textContent = '';
            }, 5000);
        });
    }

    
    const subscripcionForm = document.getElementById('subscripcion-form');
    const subscripcionMensaje = document.getElementById('subscripcion-mensaje');

    if (subscripcionForm) {
        subscripcionForm.addEventListener('submit', (e) => {
            e.preventDefault();

            
           

            subscripcionMensaje.textContent = '¡Suscripción exitosa!';
            subscripcionForm.reset();

            // Ocultar el mensaje después de unos segundos
            setTimeout(() => {
                subscripcionMensaje.textContent = '';
            }, 5000);
        });
    }
});
