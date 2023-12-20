const inputs = document.querySelectorAll(".input-field");
const toggle_btn = document.querySelectorAll(".toggle");
const main = document.querySelector("main");
const bullets = document.querySelectorAll(".bullets span");
const images = document.querySelectorAll(".image");

let currentIndex = 0;

inputs.forEach((inp) => {
  inp.addEventListener("focus", () => {
    inp.classList.add("active");
  });
  inp.addEventListener("blur", () => {
    if (inp.value !== "") return;
    inp.classList.remove("active");
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const images = document.querySelectorAll(".image");
  const textSlider = document.querySelector(".text-group");
  const bullets = document.querySelectorAll(".bullets span");

  let currentIndex = 0;

  function moveSlider(index) {
    images.forEach((img) => img.classList.remove("show"));
    images[index].classList.add("show");

    textSlider.style.transform = `translateY(${-(index) * 2.2}rem)`;

    bullets.forEach((bull) => bull.classList.remove("active"));
    bullets[index].classList.add("active");
  }

  function changeImageAutomatically() {
    currentIndex = (currentIndex + 1) % bullets.length;
    moveSlider(currentIndex);
  }

  bullets.forEach((bullet) => {
    bullet.addEventListener("click", () => {
      currentIndex = parseInt(bullet.dataset.value, 10) - 1;
      moveSlider(currentIndex);
    });
  });

  setInterval(changeImageAutomatically, 5000);
});
