var lightboxElement = document.getElementById('lightbox');
var lightboxCloseElement = document.getElementsByClassName('lightbox-close')[0];

function openLightbox() {
    lightboxElement.style.display = 'block';
}

function closeLightbox() {
    lightboxElement.style.display = 'none';
}

window.addEventListener('load', openLightbox);
lightboxCloseElement.onclick = closeLightbox;

window.onclick = function(event) {
    if (event.target === lightboxElement) {
        closeLightbox();
    }
}
