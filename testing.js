// Scroll to offer section when button is clicked
document.getElementById('offerButton').addEventListener('click', function() {
    document.getElementById('offerSection').style.display = 'block';
    window.scrollTo({
      top: document.getElementById('offerSection').offsetTop,
      behavior: 'smooth'
    });
  });
  
  // Auto slide functionality
  let currentSlide = 0;
  const slides = document.querySelectorAll('.slide');
  const totalSlides = slides.length;
  
  function showNextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    const slider = document.querySelector('.slides');
    slider.style.transform = `translateX(-${currentSlide * 100}%)`;
  }
  
  setInterval(showNextSlide, 2000); // Slide every 3 seconds
  
  // Redirect to product page
  function goToProductPage(productId) {
    window.location.href = `product.html?product=${productId}`;
  }
  