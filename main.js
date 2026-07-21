document.addEventListener("DOMContentLoaded", function () {

    const tabs = document.querySelectorAll(".tab");
    const hidden = document.getElementById("selectedService");

    tabs.forEach(tab => {

        tab.addEventListener("click", function () {

            tabs.forEach(t => t.classList.remove("active"));

            this.classList.add("active");

            hidden.value = this.dataset.service;

        });

    });

});