
const navbar = document.getElementById("mainNavbar");

window.addEventListener("scroll", () => {
  if (window.scrollY > 10) {
    navbar.classList.add("nav-scrolled");
  } else {
    navbar.classList.remove("nav-scrolled");
  }
});


document.addEventListener("DOMContentLoaded", () => {
  // Initialize all functionality
  initScrollReveal();
  initTypewriter();
  initBackToTop();
  initDarkModeToggle();
  initSkillsAnimation();
  initProjectToggle();
  initContactForm();
});

// Scroll Reveal Animation with Intersection Observer
function initScrollReveal() {
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("visible");
          
          // Special handling for skills section
          if (entry.target.id === "skills") {
            animateSkills();
          }
        }
      });
    },
    { 
      threshold: 0.1,
      rootMargin: "0px 0px -100px 0px" // Triggers when 100px from bottom of viewport
    }
  );

  document.querySelectorAll("[data-reveal]").forEach((el) => observer.observe(el));
}
// // Reveal on scroll//
// document.addEventListener("DOMContentLoaded", () => {
//   const observer = new IntersectionObserver((entries) => {
//     entries.forEach(entry => {
//       if (entry.isIntersecting) {
//         entry.target.classList.add("visible");
//         observer.unobserve(entry.target);
//       }
//     });
//   }, { threshold: 0.1 });

//   document.querySelectorAll('[data-reveal]').forEach(el => observer.observe(el));
// });

// Typing animation//
const phrases = ["Hi, I'm Mohammed Arshad", "I'm a Frontend Developer", "Web Designer", "UI Developer"];
let i = 0, j = 0, currentPhrase = [], isDeleting = false;
const el = document.getElementById("typewriter");

function loop() {
  el.innerHTML = currentPhrase.join("");
  if (!isDeleting && j < phrases[i].length) {
    currentPhrase.push(phrases[i][j++]);
  } else if (isDeleting && j > 0) {
    currentPhrase.pop();
    j--;
  }
  if (j === phrases[i].length) isDeleting = true;
  if (isDeleting && j === 0) {
    isDeleting = false;
    i = (i + 1) % phrases.length;
  }
  setTimeout(loop, isDeleting ? 50 : 150);
}
loop();

// Back to top button//
const btn = document.getElementById('backToTop');
window.onscroll = () => {
  btn.style.display = window.scrollY > 300 ? 'block' : 'none';
};
btn.onclick = () => window.scrollTo({ top: 0, behavior: 'smooth' });

// Dark mode toggle//
document.getElementById('toggleDark').onclick = () => {
  document.body.classList.toggle('dark-mode');
};

   function animateSkills() {
      const counters = document.querySelectorAll(".counter");
      const bars = document.querySelectorAll(".progress-bar");

      counters.forEach(counter => {
        const target = +counter.getAttribute("data-target");
        let count = 0;

        const update = () => {
          if (count < target) {
            count++;
            counter.textContent = `${count}%`;
            requestAnimationFrame(update);
          } else {
            counter.textContent = `${target}%`;
          }
        };

        update();
      });

      bars.forEach(bar => {
        const target = bar.getAttribute("data-target");
        bar.style.width = target + "%";
      });
    }

    // Only trigger animation once
    let hasAnimated = false;

    window.addEventListener("scroll", () => {
      const skillSection = document.getElementById("skills");
      const sectionTop = skillSection.getBoundingClientRect().top;
      const triggerPoint = window.innerHeight * 0.8;

      if (!hasAnimated && sectionTop < triggerPoint) {
        animateSkills();
        hasAnimated = true;
      }
    });

     const toggleBtn = document.getElementById('toggleProjectsBtn');
  const extraProjects = document.querySelectorAll('.extra-project');
  let expanded = false;

  toggleBtn.addEventListener('click', () => {
    expanded = !expanded;

    extraProjects.forEach(card => {
      card.classList.toggle('hidden');
    });

    toggleBtn.textContent = expanded ? 'Show Less' : 'See More';
  });




  
  const form = document.getElementById('contactForm');
  const popup = document.getElementById('successPopup');

  form.addEventListener('submit', async function (e) {
    e.preventDefault();
    const formData = new FormData(form);

    const response = await fetch('sendmail.php', {
      method: 'POST',
      body: formData
    });

    if (response.ok) {
      popup.classList.remove('hidden');
      popup.classList.add('flex');
      form.reset();
    }
  });

  function closePopup() {
    popup.classList.remove('flex');
    popup.classList.add('hidden');
  }

