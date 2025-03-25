document.addEventListener("DOMContentLoaded", function () {
    // ✅ Navbar Toggle for Mobile
    const navbarToggler = document.querySelector(".navbar-toggler");
    const navbarNav = document.querySelector("#navbarNav");
    if (navbarToggler && navbarNav) {
        navbarToggler.addEventListener("click", () => {
            navbarNav.classList.toggle("show");
            navbarToggler.setAttribute("aria-expanded", navbarNav.classList.contains("show"));
        });
    }

    // ✅ Highlight Active Navigation Link
    const navLinks = document.querySelectorAll(".nav-link");
    navLinks.forEach(link => {
        link.addEventListener("click", function () {
            navLinks.forEach(lnk => lnk.classList.remove("active"));
            this.classList.add("active");
        });
    });

    // ✅ Allow Enter Key to Trigger Click on Nav Links
    navLinks.forEach(link => {
        link.addEventListener("keydown", e => {
            if (e.key === "Enter") link.click();
        });
    });

    // ✅ Smooth Scrolling for Internal Links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener("click", function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute("href"));
            if (target) {
                target.scrollIntoView({ behavior: "smooth" });
            }
        });
    });

    // ✅ Footer Position Adjustment
    const footer = document.getElementById("footer");
    function adjustFooter() {
        if (footer) {
            footer.style.position = window.innerWidth < 768 ? "relative" : "fixed";
        }
    }
    adjustFooter();
    window.addEventListener("resize", debounce(adjustFooter, 100));

    // ✅ Footer Visibility on Scroll
    function toggleFooter() {
        if (footer) {
            footer.classList.toggle("show-footer", window.scrollY > 500);
        }
    }

    // ✅ Button Hover Effects
    document.querySelectorAll(".btn-primary").forEach(button => {
        button.addEventListener("mouseover", () => button.classList.add("hover-effect"));
        button.addEventListener("mouseout", () => button.classList.remove("hover-effect"));
    });

    // ✅ Scroll Reveal Effect for News Section
    const section = document.getElementById("news-events");
    function revealOnScroll() {
        if (section && section.getBoundingClientRect().top < window.innerHeight - 100) {
            section.classList.add("show");
        }
    }

    // ✅ Debounce Function for Scroll Events
    function debounce(func, wait = 20) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    // ✅ Attach Scroll Event Listeners
    window.addEventListener("scroll", debounce(() => {
        revealOnScroll();
        toggleFooter();
    }, 100));

    // ✅ Add Event Card Dynamically
    function addEvent() {
        const row = document.querySelector(".news-section .row");
        if (row) {
            const newCard = document.createElement("div");
            newCard.className = "col-12 col-sm-6 col-md-4 col-lg-3";
            newCard.innerHTML = `
                <div class="card h-100">
                    <img src="Images/DefaultCat.jpg" class="card-img-top" alt="New Event">
                    <div class="card-body">
                        <h5 class="card-title">New Event</h5>
                        <p class="card-text">Description of the new event...</p>
                        <a href="#" class="btn btn-danger">Read More</a>
                    </div>
                </div>
            `;
            row.insertBefore(newCard, row.lastElementChild);
        }
    }

    const addEventButton = document.querySelector(".btn-outline-danger");
    if (addEventButton) {
        addEventButton.addEventListener("click", addEvent);
    }

    // ✅ Form Submission Handlers
    const contactForm = document.getElementById("contactForm");
    if (contactForm) {
        contactForm.addEventListener("submit", function (e) {
            e.preventDefault();
            alert("Thank you for your message! We will get back to you shortly.");
            contactForm.reset();
        });
    }

    document.querySelector(".stay-connected form").addEventListener("submit", function (e) {
        e.preventDefault();
        alert("Thank you for reaching out! We will get back to you soon.");
    });

    // ✅ Form Validation
    document.getElementById('contactForm').addEventListener('submit', function (e) {
        const fullName = document.getElementById('fullName').value.trim();
        const email = document.getElementById('email').value.trim();
        const contactNumber = document.getElementById('contactNumber').value.trim();

        if (!fullName || !email || !contactNumber) {
            e.preventDefault();
            alert('Please fill out all required fields.');
        }
    });

    // ✅ Animation for "Find Us" Icons
    const findUsIcons = document.querySelectorAll(".find-us i");
    findUsIcons.forEach(icon => {
        icon.addEventListener("mouseover", () => icon.classList.add("fa-bounce"));
        icon.addEventListener("mouseout", () => icon.classList.remove("fa-bounce"));
    });

    // ✅ Smooth Scroll to "Our Departments" Section
    const departmentsLink = document.querySelector('a[href="#departments"]');
    if (departmentsLink) {
        departmentsLink.addEventListener("click", function (e) {
            e.preventDefault();
            const target = document.querySelector(".departments-section");
            if (target) {
                target.scrollIntoView({ behavior: "smooth" });
            }
        });
    }
});
