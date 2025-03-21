// Получаем элементы слайд-шоу
const slideshowContainer = document.querySelector('.slideshow-container');
const slides = document.querySelectorAll('.slide');
const prevBtn = document.querySelector('.prev');
const nextBtn = document.querySelector('.next');
const dotsContainer = document.querySelector('.dots-container');

let slideIndex = 0;

// Функция для создания индикаторов (точек)
function createDots() {
    if (!dotsContainer) return; // Защита от ошибки, если нет dotsContainer
  for (let i = 0; i < slides.length; i++) {
    const dot = document.createElement('span');
    dot.classList.add('dot');
    dot.dataset.slide = i; // Связываем точку с индексом слайда
    dotsContainer.appendChild(dot);
  }
}

// Функция для активации текущей точки
function activateDot(index) {
    if (!dotsContainer) return; // Защита от ошибки, если нет dotsContainer
  const dots = document.querySelectorAll('.dot');
  dots.forEach(dot => dot.classList.remove('active'));
  dots[index].classList.add('active');
}

// Функция для показа слайда
function showSlide(index) {
    if (!slides) return; // Защита от ошибки, если нет slides
  if (index < 0) {
    slideIndex = slides.length - 1;
  } else if (index >= slides.length) {
    slideIndex = 0;
  }

  slides.forEach(slide => slide.style.display = 'none');
  slides[slideIndex].style.display = 'block';

  activateDot(slideIndex);
}

// Функция для перехода к предыдущему слайду
function prevSlide() {
    if (!slides) return; // Защита от ошибки, если нет slides
  slideIndex--;
  showSlide(slideIndex);
}

// Функция для перехода к следующему слайду
function nextSlide() {
    if (!slides) return; // Защита от ошибки, если нет slides
  slideIndex++;
  showSlide(slideIndex);
}

// Инициализация слайд-шоу
function init() {
    if (!slideshowContainer) return; // Защита от ошибки, если нет slideshowContainer
  createDots();
  showSlide(slideIndex);
  activateDot(slideIndex);

  // Автоматическая смена слайдов (каждые 5 секунд)
  setInterval(nextSlide, 5000);
}

// Обработчики событий для кнопок
if (prevBtn && nextBtn) {
  prevBtn.addEventListener('click', prevSlide);
  nextBtn.addEventListener('click', nextSlide);
}

// Обработчик событий для точек
if (dotsContainer) {
    dotsContainer.addEventListener('click', function(event) {
      if (event.target.classList.contains('dot')) {
        slideIndex = parseInt(event.target.dataset.slide);
        showSlide(slideIndex);
      }
    });
}

// Запускаем слайд-шоу после загрузки страницы
window.addEventListener('load', init);