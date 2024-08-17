$('.collapsible').collapsible();

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOMContentLoaded');
    var elems = document.querySelectorAll('.slider');
    var instances = M.Slider.init(elems, {
      indicators: true,
      height: 400, // Ajuste conforme necessário
      interval: 6000 // Ajuste conforme necessário
    });
});