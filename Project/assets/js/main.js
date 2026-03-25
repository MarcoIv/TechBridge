// CONFIRMATION DIALOGS : Adds a confirmation dialog to any element with the data-confirm attribute. When the element is clicked, it prompts the user with the specified message, and if the user cancels, it prevents the default action (like form submission or link navigation).
document.addEventListener("DOMContentLoaded", () => {
    const toggles = document.querySelectorAll("[data-confirm]");
    toggles.forEach(btn => {
        btn.addEventListener("click", e => {
            const msg = btn.getAttribute("data-confirm") || "Are you sure?";
            if (!confirm(msg)) {
                e.preventDefault();
            }
        });
    });
});

// MOBILE NAVIGATION : Turns the menu into a hamburger menu on smaller screens. The button toggles the visibility of the mobile menu and changes its own appearance to indicate whether the menu is open or closed.
document.addEventListener("DOMContentLoaded", () => {
    const hamburger = document.getElementById("hamburger-btn");
    const mobileMenu = document.getElementById("mobile-menu");

    hamburger.addEventListener("click", () => {
        mobileMenu.classList.toggle("open");
        hamburger.classList.toggle("active");
    });
});

// LAZY LOADING IMAGES : Loads images only when they are about to enter the viewport, improving page load times.
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("img[loading='lazy']").forEach(img => {

        // If the image is already cached and loaded
        if (img.complete) {
            img.setAttribute("data-loaded", "true");
        }

        // If the image loads normally
        img.addEventListener("load", () => {
            img.setAttribute("data-loaded", "true");
        });
    });
});

document.addEventListener("DOMContentLoaded", () => {

    // PRODUCT QUOTE CALCULATOR : Calculates the total price based on selected options.
    const quoteForm = document.getElementById("quoteForm");
    if (quoteForm) {
        const basePrice = parseFloat(document.getElementById("basePrice").textContent);
        const totalSpan = document.getElementById("totalPrice");

        quoteForm.addEventListener("change", () => {
            let total = basePrice;
            quoteForm.querySelectorAll("input[type=checkbox]:checked").forEach(cb => {
                total += parseFloat(cb.dataset.extra);
            });
            totalSpan.textContent = total.toFixed(2);
        });
    }

    // SERVICE ESTIMATOR (estimate.php)
    const estimateForm = document.getElementById("estimateForm");
    if (estimateForm) {
        const serviceType = document.getElementById("serviceType");
        const urgency = document.getElementById("urgency");
        const estimateTotal = document.getElementById("estimateTotal");

        function updateEstimate() {
            const total = parseFloat(serviceType.value) + parseFloat(urgency.value);
            estimateTotal.textContent = total.toFixed(2);
        }

        serviceType.addEventListener("change", updateEstimate);
        urgency.addEventListener("change", updateEstimate);
    }

});