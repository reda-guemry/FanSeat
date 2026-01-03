let currentStep = 1;
const totalSteps = 4;
const nextBtn = document.getElementById("nextBtn");
const prevBtn = document.getElementById("prevBtn");
const submitBtn = document.getElementById("submitBtn");

function updateSteps() {
  // Hide all steps
  document.querySelectorAll(".form-step").forEach((step) => {
    step.classList.add("hidden");
  });

  // Show current step
  document.getElementById(`step${currentStep}`).classList.remove("hidden");

  // Update step indicators
  document.querySelectorAll(".step-item").forEach((item, index) => {
    const circle = item.querySelector(".step-circle");
    const label = item.querySelector(".step-label");

    if (index + 1 < currentStep) {
      // Completed
      circle.classList.remove("bg-gray-300", "text-gray-600", "bg-purple-600");
      circle.classList.add("bg-green-600", "text-white");
      circle.textContent = "✓";
      label.classList.remove("text-gray-500", "text-purple-600");
      label.classList.add("text-green-600");
    } else if (index + 1 === currentStep) {
      // Active
      circle.classList.remove("bg-gray-300", "text-gray-600", "bg-green-600");
      circle.classList.add("bg-purple-600", "text-white");
      circle.textContent = index + 1;
      label.classList.remove("text-gray-500", "text-green-600");
      label.classList.add("text-purple-600");
    } else {
      // Inactive
      circle.classList.remove("bg-purple-600", "bg-green-600");
      circle.classList.add("bg-gray-300", "text-gray-600");
      circle.textContent = index + 1;
      label.classList.remove("text-purple-600", "text-green-600");
      label.classList.add("text-gray-500");
    }
  });

  // Update progress line
  const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;

  document
    .getElementById("stepLine")
    .style.setProperty("--progress", progress + "%");

  // Update buttons
  prevBtn.classList.toggle("hidden", currentStep === 1);
  nextBtn.classList.toggle("hidden", currentStep === totalSteps);
  submitBtn.classList.toggle("hidden", currentStep !== totalSteps);

  // Update preview on step 4
  if (currentStep === 4) {
    updatePreview();
  }
}

nextBtn.addEventListener("click", () => {
  if (validateStep(currentStep)) {
    currentStep++;
    updateSteps();
    window.scrollTo({ top: 0, behavior: "smooth" });
  }
});

prevBtn.addEventListener("click", () => {
  currentStep--;
  updateSteps();
  window.scrollTo({ top: 0, behavior: "smooth" });
});

function validateStep(step) {
  if (step === 1) {
    const team1 = document.getElementById("team1Name").value;
    const team2 = document.getElementById("team2Name").value;
    if (!team1 || !team2) {
      alert("Veuillez renseigner les noms des deux équipes.");
      return false;
    }
  } else if (step === 2) {
    const date = document.getElementById("matchDate").value;
    const time = document.getElementById("matchTime").value;
    const stadium = document.getElementById("stadiumName").value;
    const city = document.getElementById("city").value;
    if (!date || !time || !stadium || !city) {
      alert("Veuillez remplir tous les champs obligatoires.");
      return false;
    }
  } else if (step === 3) {
    const cat1Price = document.querySelector(
      '[data-category="1"] .category-price'
    ).value;
    const cat1Places = document.querySelector(
      '[data-category="1"] .category-places'
    ).value;
    if (!cat1Price || !cat1Places) {
      alert("Veuillez configurer au moins la catégorie VIP.");
      return false;
    }
  }
  return true;
}

function updatePreview() {
  // Teams
    document.getElementById("previewTeam1").textContent =
    document.getElementById("team1Name").value || "Équipe 1";
    document.getElementById("previewTeam2").textContent =
    document.getElementById("team2Name").value || "Équipe 2";

  // Date & Time
    const date = document.getElementById("matchDate").value;
    const time = document.getElementById("matchTime").value;
    if (date && time) {
        const dateObj = new Date(date);
        const options = { day: "numeric", month: "long", year: "numeric" };
        document.getElementById(
        "previewDate"
        ).innerHTML = `<i class="fas fa-calendar-alt mr-2"></i>${dateObj.toLocaleDateString(
        "fr-FR",
        options
        )} - ${time}`;
    }

  // Location
  const stadium = document.getElementById("stadiumName").value;
  const city = document.getElementById("city").value;
  document.getElementById(
    "previewLocation"
  ).textContent = `${stadium}, ${city}`;

  // Total Places
  const totalPlaces = document.getElementById("totalPlaces").value;
  document.getElementById(
    "previewPlaces"
  ).textContent = `${totalPlaces} places`;

  // Categories summary
  let summaryHtml = "";
  let totalPlacesSum = 0;
  let totalRevenue = 0;
  let minPrice = Infinity;

  document
    .querySelectorAll('.category-card, [data-category="1"]')
    .forEach((card) => {
      const toggle = card.querySelector(".category-toggle");
      if (!toggle || toggle.checked || card.dataset.category === "1") {
        const name = card.querySelector(".category-name").value;
        const price =
          parseInt(card.querySelector(".category-price").value) || 0;
        const places =
          parseInt(card.querySelector(".category-places").value) || 0;

        if (places > 0 && price > 0) {
          const revenue = price * places;
          totalPlacesSum += places;
          totalRevenue += revenue;
          if (price < minPrice) minPrice = price;

          summaryHtml += `
                        <tr class="border-b border-purple-100">
                            <td class="px-6 py-4 font-semibold">${name}</td>
                            <td class="px-6 py-4">${places}</td>
                            <td class="px-6 py-4">${price} MAD</td>
                            <td class="px-6 py-4 font-bold text-purple-700">${revenue.toLocaleString()} MAD</td>
                        </tr>
                    `;
        }
      }
    });

  document.getElementById("categoriesSummaryBody").innerHTML = summaryHtml;
  document.getElementById("totalPlacesSummary").textContent = totalPlacesSum;
  document.getElementById("totalRevenueSummary").textContent =
    totalRevenue.toLocaleString() + " MAD";
  document.getElementById("previewPrice").textContent = `À partir de ${
    minPrice === Infinity ? "--" : minPrice
  } MAD`;
}

// Logo preview
    ["team1Logo", "team2Logo"].forEach((id, index) => {
    document.getElementById(id).addEventListener("change", function (e) {
        const file = e.target.files[0];
        if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById(
            `logo${index + 1}Preview`
            ).innerHTML = `<img src="${e.target.result}" alt="Logo" class="w-full h-full object-cover">`;
        };
        reader.readAsDataURL(file);
        }
    });
});

// Category toggle
document.querySelectorAll(".category-toggle").forEach((toggle) => {
  toggle.addEventListener("change", function () {
    const card = this.closest(".category-card");
    const content = card.querySelector(".category-content");
    const toggleBg = card.querySelector(".toggle-bg");
    const toggleDot = card.querySelector(".toggle-dot");

    if (this.checked) {
      content.classList.remove("opacity-30", "pointer-events-none");
      toggleBg.classList.remove("bg-gray-400");
      toggleDot.classList.remove("left-1");
      toggleDot.classList.add("right-1");

      // Set color based on category
      if (card.dataset.category === "2") {
        toggleBg.classList.add("bg-green-600");
      } else {
        toggleBg.classList.add("bg-yellow-600");
      }
    } else {
      content.classList.add("opacity-30", "pointer-events-none");
      toggleBg.classList.add("bg-gray-400");
      toggleBg.classList.remove("bg-green-600", "bg-yellow-600");
      toggleDot.classList.add("left-1");
      toggleDot.classList.remove("right-1");
    }
  });
});

// Calculate places
document.querySelectorAll(".category-places").forEach((input) => {
  input.addEventListener("input", updatePlacesSummary);
});

function updatePlacesSummary() {
  let total = 0;
  document
    .querySelectorAll('.category-card, [data-category="1"]')
    .forEach((card) => {
      const toggle = card.querySelector(".category-toggle");
      if (!toggle || toggle.checked || card.dataset.category === "1") {
        const places =
          parseInt(card.querySelector(".category-places").value) || 0;
        total += places;
      }
    });

  document.getElementById("configuredPlaces").textContent = total;
  const maxPlaces =
    parseInt(document.getElementById("totalPlaces").value) || 2000;
  document.getElementById("remainingPlaces").textContent = Math.max(
    0,
    maxPlaces - total
  );
}

// Form submission
document
  .getElementById("createMatchForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();
    if (document.getElementById("termsAccept").checked) {
      document.getElementById("successModal").classList.remove("hidden");
      document.getElementById("successModal").classList.add("flex");
    } else {
      alert("Veuillez accepter les conditions générales.");
    }
  });

// Initialize
updateSteps();
