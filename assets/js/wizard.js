/**
 * Setup Wizard JavaScript
 */

// Globale Variablen SOFORT exponieren (außerhalb IIFE, damit sie beim Script-Load verfügbar sind)
window.uploadedFiles = {
  elementorPro: false,
  elementorProActivated: false,
  templateKit: false,
  acfJson: false,
  demoData: false,
  logo: false,
  headingFont: false,
  bodyFont: false,
};

// Globale Funktionen als Platzhalter (werden später überschrieben)
// Diese Funktion kann sofort verwendet werden (braucht kein jQuery)
window.markStepCompleted = function (stepNumber) {
  if (typeof psychoWizard === "undefined") {
    console.log("markStepCompleted: psychoWizard not loaded yet");
    return;
  }
  jQuery.ajax({
    url: psychoWizard.ajaxUrl,
    type: "POST",
    data: {
      action: "psycho_mark_step_completed",
      nonce: psychoWizard.nonce,
      step: stepNumber,
    },
    success: function (response) {
      // Progress Bubble sofort aktualisieren
      jQuery(`.step[data-step="${stepNumber}"]`).addClass("completed");
      console.log(
        "Step " +
          stepNumber +
          " marked as completed and progress bubble updated"
      );
    },
  });
};

// Platzhalter für andere Funktionen (werden in IIFE überschrieben)
window.updateButtons = function () {
  console.log("updateButtons placeholder called");
};
window.nextStep = function () {
  console.log("nextStep placeholder called");
};

// Notification System (ECHTE Implementierung - ES5 kompatibel)
window.showNotification = function (type, message) {
  console.log("showNotification called:", type, message);

  // Erstelle Notification Container falls nicht vorhanden
  var $container = jQuery("#psycho-notification-container");
  if (!$container.length) {
    jQuery("body").append(
      '<div id="psycho-notification-container" style="position: fixed; top: 20px; right: 20px; z-index: 999999; max-width: 400px;"></div>'
    );
    $container = jQuery("#psycho-notification-container");
  }

  // Farben basierend auf Typ
  var colors = {
    success: { bg: "#d1fae5", border: "#10b981", text: "#065f46", icon: "✅" },
    error: { bg: "#fee2e2", border: "#ef4444", text: "#991b1b", icon: "❌" },
    info: { bg: "#dbeafe", border: "#3b82f6", text: "#1e3a8a", icon: "ℹ️" },
    warning: { bg: "#fef3c7", border: "#f59e0b", text: "#92400e", icon: "⚠️" },
  };

  var color = colors[type] || colors["info"];

  // Erstelle Notification
  var $notification = jQuery('<div class="psycho-notification"></div>');
  $notification.css({
    background: color.bg,
    border: "2px solid " + color.border,
    "border-radius": "8px",
    padding: "15px 20px",
    "margin-bottom": "10px",
    "box-shadow": "0 4px 6px rgba(0,0,0,0.1)",
    color: color.text,
    "font-weight": "500",
    display: "flex",
    "align-items": "center",
    gap: "10px",
    opacity: "0",
    transform: "translateX(100px)",
  });

  $notification.html("<strong>" + color.icon + " " + message + "</strong>");

  // Füge zu Container hinzu
  $container.append($notification);

  console.log("Notification added to DOM");

  // Animation (ES5 Syntax)
  setTimeout(function () {
    $notification.css({
      opacity: "1",
      transform: "translateX(0)",
      transition: "all 0.3s ease-out",
    });
  }, 10);

  // Auto-Remove nach 8 Sekunden (länger damit User es sieht)
  setTimeout(function () {
    $notification.css({
      opacity: "0",
      transform: "translateX(100px)",
      transition: "all 0.3s ease-in",
    });
    setTimeout(function () {
      $notification.remove();
    }, 300);
  }, 8000);

  console.log("Notification setup complete");
};

(function ($) {
  "use strict";

  let currentStep = 1;
  const totalSteps = 16;
  let selectedScheme = null;
  // uploadedFiles ist jetzt global als window.uploadedFiles
  const uploadedFiles = window.uploadedFiles;

  // Farbschemas: Jedes Schema hat 10 Basis-Farben
  // [Primary, Secondary, Text, Info, Warning, Error, Background, Surface, Muted, Border]
  // PHP berechnet automatisch die 3 Hover-Farben (15% dunkler) und erstellt alle 23 Custom Colors
  const colorSchemes = {
    "template-standard": {
      name: "✨ Template Standard",
      colors: [
        "#2F6D67",
        "#6FA89F",
        "#1A1F23",
        "#0D47A1",
        "#8C6E00",
        "#C0392B",
        "#FAFAF8",
        "#F2F5F3",
        "#5B6366",
        "#D9E3DF",
      ],
    },
    "sage-green": {
      name: "🌿 Salbeigrün",
      colors: [
        "#5D7D5D",
        "#B8C9B8",
        "#2A2F2A",
        "#5B8CA8",
        "#A89D5B",
        "#A85B5B",
        "#F7F9F7",
        "#EFF3EF",
        "#6B716B",
        "#D4DDD4",
      ],
    },
    "soft-lavender": {
      name: "💜 Sanfte Lavendeltöne",
      colors: [
        "#5A6A99",
        "#A8B3D4",
        "#2E2E3A",
        "#6A9AB0",
        "#B5A67C",
        "#A86B6B",
        "#F9F9FC",
        "#F0F0F5",
        "#6B6B7D",
        "#D8D8E8",
      ],
    },
    "warm-rose": {
      name: "🌸 Warme Rosétöne",
      colors: [
        "#B8644D",
        "#E8AFA6",
        "#3A2E2E",
        "#7FA3B8",
        "#D4A87B",
        "#B86B6B",
        "#FCF8F7",
        "#F5EFED",
        "#7D6E6B",
        "#E8DDD8",
      ],
    },
    "warm-blue-apricot": {
      name: "🌊 Blaugrau/Apricot",
      colors: [
        "#5A7387",
        "#A8BDC9",
        "#232A2E",
        "#5B7FA8",
        "#D4A03D",
        "#C64B42",
        "#FAFBFC",
        "#EEF3F5",
        "#656B70",
        "#D6E1E7",
      ],
    },
    "chocolate-mokka": {
      name: "☕ Schokobraun",
      colors: [
        "#6B5447",
        "#9B8577",
        "#2F2926",
        "#5B7FA8",
        "#A88D47",
        "#A84D47",
        "#FAF8F7",
        "#F0EBE8",
        "#6B6560",
        "#DDD5D0",
      ],
    },
    "clear-blue": {
      name: "💙 Klares Mittelblau",
      colors: [
        "#3D6B94",
        "#8FB3D4",
        "#232A2F",
        "#4A7BA7",
        "#B8A047",
        "#B84D4D",
        "#F7FAFC",
        "#EDF3F7",
        "#5F666B",
        "#D4E1EA",
      ],
    },
    "deep-terracotta": {
      name: "🍂 Tiefes Terracotta",
      colors: [
        "#A85840",
        "#D4936B",
        "#2F2623",
        "#5B84A8",
        "#B89447",
        "#B84747",
        "#FCF8F6",
        "#F5EEEA",
        "#6F6560",
        "#E8DDD4",
      ],
    },
    "soft-mauve": {
      name: "🪻 Weiches Mauve",
      colors: [
        "#856478",
        "#C9B3BE",
        "#2A2628",
        "#6B8AA8",
        "#C9A350",
        "#B84D4D",
        "#FDFBFC",
        "#F5F0F3",
        "#6F696D",
        "#E3D8DE",
      ],
    },
  };

  // Typography Schemas: Nur Font-Family wird geändert, Größen/Line-Heights bleiben
  // Format: { primary, secondary, text, accent, small_text, number_big, quote }
  const typographySchemes = {
    "template-standard": {
      name: "📖 Template Standard",
      fonts: {
        primary: "Instrument Serif",
        secondary: "Inter",
        text: "Inter",
        accent: "Inter",
        small_text: "Inter",
        number_big: "Instrument Serif",
        quote: "Instrument Serif",
      },
    },
    "modern-sans": {
      name: "🎯 Modern Sans",
      fonts: {
        primary: "Inter",
        secondary: "Inter",
        text: "Inter",
        accent: "Inter",
        small_text: "Inter",
        number_big: "Inter",
        quote: "Inter",
      },
    },
    "elegant-serif": {
      name: "✨ Elegant Serif",
      fonts: {
        primary: "Playfair Display",
        secondary: "Inter",
        text: "Inter",
        accent: "Inter",
        small_text: "Inter",
        number_big: "Playfair Display",
        quote: "Playfair Display",
      },
    },
    "warm-friendly": {
      name: "😊 Warm & Friendly",
      fonts: {
        primary: "Outfit",
        secondary: "Outfit",
        text: "Inter",
        accent: "Outfit",
        small_text: "Inter",
        number_big: "Outfit",
        quote: "Outfit",
      },
    },
    professional: {
      name: "💼 Professional",
      fonts: {
        primary: "Montserrat",
        secondary: "Montserrat",
        text: "Inter",
        accent: "Montserrat",
        small_text: "Inter",
        number_big: "Montserrat",
        quote: "Montserrat",
      },
    },
    "warm-inviting": {
      name: "🏡 Warm & Einladend",
      fonts: {
        primary: "Merriweather",
        secondary: "Merriweather",
        text: "Lato",
        accent: "Merriweather",
        small_text: "Lato",
        number_big: "Merriweather",
        quote: "Merriweather",
      },
    },
    "calm-harmonious": {
      name: "🧘 Ruhig & Harmonisch",
      fonts: {
        primary: "Poppins",
        secondary: "Poppins",
        text: "Nunito",
        accent: "Poppins",
        small_text: "Nunito",
        number_big: "Poppins",
        quote: "Poppins",
      },
    },
    "timeless-serious": {
      name: "⚖️ Zeitlos & Seriös",
      fonts: {
        primary: "Cormorant Garamond",
        secondary: "Cormorant Garamond",
        text: "Raleway",
        accent: "Cormorant Garamond",
        small_text: "Raleway",
        number_big: "Cormorant Garamond",
        quote: "Cormorant Garamond",
      },
    },
  };

  // Bei Seitenload initialisieren
  $(document).ready(function () {
    // Debug: Log localized strings
    console.log("=== Psycho Wizard i18n Debug ===");
    console.log("Locale:", document.documentElement.lang);
    console.log("startBtn:", psychoWizard.i18n.startBtn);
    console.log("nextBtn:", psychoWizard.i18n.nextBtn);
    console.log("================================");

    // Zeige Loading während Status geladen wird
    window.showNotification("info", "Lade gespeicherten Status...");

    initWizard();

    // Check if we should skip auto-jump (z.B. nach Status-Check reload)
    const noAutoJump =
      sessionStorage.getItem("psycho_wizard_no_autojump") === "true";
    const stayOnStep = sessionStorage.getItem("psycho_wizard_stay_on_step");

    if (noAutoJump) {
      sessionStorage.removeItem("psycho_wizard_no_autojump");
    }
    if (stayOnStep) {
      currentStep = parseInt(stayOnStep);
      sessionStorage.removeItem("psycho_wizard_stay_on_step");
      updateSteps();
      updateProgress();
    }

    loadWizardStatus(!noAutoJump);
  });

  function initWizard() {
    updateProgress();
    window.updateButtons();
    setupEventHandlers();
    setupFileUploads();
  }

  /**
   * Lade gespeicherten Wizard-Status
   * @param {boolean} autoJump - Whether to automatically jump to next incomplete step (default: true)
   */
  function loadWizardStatus(autoJump = true) {
    $.ajax({
      url: psychoWizard.ajaxUrl,
      type: "POST",
      data: {
        action: "psycho_get_status",
        nonce: psychoWizard.nonce,
      },
      success: function (response) {
        if (response.success) {
          const status = response.data;
          console.log("Wizard Status:", status);

          // Sammle automatisch abgeschlossene Steps
          let autoCompletedSteps = [];

          // Step 2: Hello Theme
          if (status.hello_theme_active) {
            $("#helloTheme")
              .removeClass("status-pending")
              .addClass("status-installed")
              .text(psychoWizard.i18n.installed);
            autoCompletedSteps.push(2);
          }

          // Step 3: Elementor
          if (status.elementor_active) {
            $("#elementor")
              .removeClass("status-pending")
              .addClass("status-installed")
              .text(psychoWizard.i18n.installed);
            autoCompletedSteps.push(3);
          }

          // Step 4: Elementor Pro
          if (status.elementor_pro_active) {
            uploadedFiles.elementorPro = true;
          }

          if (status.elementor_pro_license_active) {
            uploadedFiles.elementorProActivated = true;
            autoCompletedSteps.push(4);
          }

          // Step 5: Template Kit - Auto-Check wenn auf Step 5
          if (
            status.wizard_status &&
            status.wizard_status.template_kit_imported
          ) {
            uploadedFiles.templateKit = true;
            autoCompletedSteps.push(5);
          } else if (
            currentStep === 5 ||
            (status.wizard_status && status.wizard_status.current_step === 5)
          ) {
            // Wenn auf Step 5, automatisch prüfen ob Templates da sind
            setTimeout(function () {
              autoCheckTemplateImport();
            }, 1500);
          }

          // Step 6: ACF
          if (status.wizard_status && status.wizard_status.acf_imported) {
            uploadedFiles.acfJson = true;
            autoCompletedSteps.push(6);
          }

          // Step 7: Team Settings (wird über completed_steps gecheckt)
          if (
            status.wizard_status &&
            status.wizard_status.team_settings_configured
          ) {
            autoCompletedSteps.push(7);
          }

          // Step 8: Styling Plugin
          if (
            status.wizard_status &&
            status.wizard_status.styling_plugin_installed
          ) {
            $("#stylingPlugin")
              .removeClass("status-pending")
              .addClass("status-installed")
              .text(psychoWizard.i18n.installed);
            autoCompletedSteps.push(8);
          }

          // Step 9: Demo Data
          if (status.wizard_status && status.wizard_status.demo_data_imported) {
            uploadedFiles.demoData = true;
            autoCompletedSteps.push(9);
          }

          // Step 10: Privacy Page
          if (
            status.wizard_status &&
            status.wizard_status.privacy_page_published
          ) {
            autoCompletedSteps.push(10);
          }

          // Step 11: Colors
          if (status.wizard_status && status.wizard_status.colors_set) {
            selectedScheme = "loaded"; // Markiere als gesetzt
            autoCompletedSteps.push(11);
          }

          // Step 12: Fonts
          if (status.wizard_status && status.wizard_status.fonts_uploaded) {
            uploadedFiles.headingFont = true;
            uploadedFiles.bodyFont = true;
            autoCompletedSteps.push(12);
          }

          // Step 13: Colors (bereits oben bei Step 11 geprüft)

          // Step 14: Typography
          if (status.wizard_status && status.wizard_status.typography_set) {
            autoCompletedSteps.push(14);
          }

          // Step 15: Styles
          if (status.wizard_status && status.wizard_status.styles_set) {
            autoCompletedSteps.push(15);
          }

          // Kombiniere gespeicherte completed_steps mit auto-erkannten
          let allCompletedSteps = autoCompletedSteps;
          if (status.wizard_status && status.wizard_status.completed_steps) {
            // Merge beide Arrays und entferne Duplikate
            allCompletedSteps = [
              ...new Set([
                ...autoCompletedSteps,
                ...status.wizard_status.completed_steps,
              ]),
            ];
          }

          // WICHTIG: Entferne Step 2 und 3 wenn Theme/Plugin nicht aktiv ist
          // Diese Steps müssen dynamisch sein basierend auf dem tatsächlichen Status
          if (!status.hello_theme_active) {
            allCompletedSteps = allCompletedSteps.filter((step) => step !== 2);
          }
          if (!status.elementor_active) {
            allCompletedSteps = allCompletedSteps.filter((step) => step !== 3);
          }
          // Step 5 (Template Kit) nur als completed wenn auch wirklich importiert
          if (
            !status.wizard_status ||
            !status.wizard_status.template_kit_imported
          ) {
            allCompletedSteps = allCompletedSteps.filter((step) => step !== 5);
          }

          console.log("Auto-completed steps:", autoCompletedSteps);
          console.log("All completed steps:", allCompletedSteps);

          // Markiere alle abgeschlossenen Steps in der Progress Bar
          // Erst alle 'completed' Klassen entfernen, dann nur die aktuell abgeschlossenen markieren
          $(".step").removeClass("completed");
          allCompletedSteps.forEach(function (stepNum) {
            $(`.step[data-step="${stepNum}"]`).addClass("completed");
          });

          // Step Namen für die Anzeige
          const stepNames = [
            "", // Index 0 leer
            "Willkommen", // 1
            "Hello Theme", // 2
            "Elementor", // 3
            "Elementor Pro", // 4
            "Template Kit", // 5
            "ACF Setup", // 6
            "Team Settings", // 7
            "Styling Plugin", // 8
            "Demo Daten", // 9
            "Datenschutz", // 10
            "Templates", // 11
            "WP Settings", // 12
            "Farben", // 13
            "Schriftarten", // 14
            "Styles", // 15
            "Fertig", // 16
          ];

          // Finde ersten nicht-abgeschlossenen Step (Step 1 überspringen - ist nur Welcome)
          let nextIncompleteStep = 1;
          if (allCompletedSteps.length > 0) {
            // Gehe durch alle Steps 2-13 und finde den ersten nicht-abgeschlossenen
            // (Step 1 überspringen, da es nur die Welcome Page ist)
            for (let i = 2; i <= totalSteps; i++) {
              if (!allCompletedSteps.includes(i)) {
                nextIncompleteStep = i;
                break;
              }
            }

            // Wenn alle Steps abgeschlossen sind, gehe zum letzten Step
            if (allCompletedSteps.length >= totalSteps - 1) {
              // -1 weil Step 1 nicht gezählt wird
              nextIncompleteStep = totalSteps;
            }
          }

          // Aktualisiere "Fortsetzen" Kachel auf Welcome Page
          console.log("nextIncompleteStep:", nextIncompleteStep);
          console.log(
            "continueSetupCard exists:",
            $("#continueSetupCard").length
          );

          if (nextIncompleteStep > 1 && $("#continueSetupCard").length) {
            console.log(
              "Zeige Fortsetzen-Kachel für Step:",
              nextIncompleteStep,
              stepNames[nextIncompleteStep]
            );
            $("#nextStepName").text(stepNames[nextIncompleteStep]);
            $("#continueSetupCard").fadeIn();

            // Button Handler zum Springen
            $("#jumpToNextStep")
              .off("click")
              .on("click", function () {
                console.log("Springe zu Step:", nextIncompleteStep);
                currentStep = nextIncompleteStep;
                updateSteps();
                updateProgress();
                window.updateButtons();
                window.showNotification(
                  "success",
                  "Weiter bei Schritt " +
                    nextIncompleteStep +
                    ": " +
                    stepNames[nextIncompleteStep]
                );
              });
          } else {
            console.log(
              "Kachel wird NICHT angezeigt. nextIncompleteStep:",
              nextIncompleteStep,
              "Card exists:",
              $("#continueSetupCard").length
            );
          }

          // Springe zum nächsten unvollständigen Step (NICHT automatisch wenn auf Step 1)
          if (autoJump && nextIncompleteStep > 1 && currentStep !== 1) {
            // Zeige erfolgreiche Status-Nachricht
            window.showNotification(
              "success",
              "Fortschritt wiederhergestellt! Weiter bei Schritt " +
                nextIncompleteStep
            );

            // Automatisch zum nächsten unvollständigen Step springen
            setTimeout(function () {
              currentStep = nextIncompleteStep;
              updateSteps();
              updateProgress();
              window.updateButtons();
            }, 800);
          } else if (currentStep === 1) {
            // Auf Welcome Page - zeige Kachel aber springe nicht
            window.showNotification("success", "Setup-Wizard bereit!");
          } else {
            // Erster Start
            window.showNotification("success", "Setup-Wizard bereit!");
          }

          window.updateButtons();
        }
      },
      error: function () {
        window.showNotification(
          "error",
          "Fehler beim Laden des Status. Starte von vorne."
        );
      },
    });
  }

  /**
   * Speichere aktuellen Step
   */
  function saveCurrentStep() {
    $.ajax({
      url: psychoWizard.ajaxUrl,
      type: "POST",
      data: {
        action: "psycho_save_step",
        nonce: psychoWizard.nonce,
        step: currentStep,
      },
    });
  }

  function setupEventHandlers() {
    // Navigation Buttons
    $("#prevBtn").on("click", previousStep);
    $("#nextBtn").on("click", window.nextStep);

    // Progress Points Click Handler - Springe zu Step
    $(document).on("click", ".step", function () {
      const targetStep = parseInt($(this).data("step"));

      if (
        targetStep &&
        targetStep !== currentStep &&
        targetStep >= 1 &&
        targetStep <= totalSteps
      ) {
        console.log("Springe von Step", currentStep, "zu Step", targetStep);
        currentStep = targetStep;
        updateSteps();
        updateProgress();
        window.updateButtons();
        window.showNotification(
          "info",
          "Zu Schritt " + targetStep + " gesprungen"
        );
      }
    });

    // Color Scheme Selection - Apply immediately on click (like Step 15)
    $(".color-scheme").on("click", function (e) {
      if ($(e.target).hasClass("preview-btn")) return;

      const $this = $(this);
      const scheme = $this.data("scheme");

      // Verhindere Doppel-Klicks während Farben angewendet werden
      if (isApplyingColors || $this.hasClass("applying")) return;

      selectedScheme = scheme;

      // Visuelles Feedback - Optimistic UI Update
      $(".color-scheme").removeClass("selected active applying");
      $this.addClass("selected active applying");

      // Farben sofort anwenden
      applyColorsImmediately();
    });

    // Color Preview Buttons
    $(".preview-btn").on("click", function (e) {
      e.stopPropagation();
      const scheme = $(this).closest(".color-scheme").data("scheme");
      previewScheme(scheme);
    });

    // Demo Data Checkbox
    $("#importDemo").on("change", function () {
      $("#demoUpload").toggle(this.checked);
    });
  }

  function setupFileUploads() {
    // Step 4: Elementor Pro Upload (immer sichtbar, daher hier registriert)
    if ($("#proUpload").length) {
      setupUploadArea("proUpload", "elementorPro", function (file) {
        uploadElementorPro(file);
      });
    }

    // Alle anderen Upload-Bereiche werden dynamisch in setupStepUploads() registriert
    // wenn der jeweilige Step aktiv wird (Step 6, 7, 8, 9, 12)
  }

  // Upload Styling Plugin Function
  window.uploadStylingPlugin = function (file) {
    if (!file.name.endsWith(".zip")) {
      window.showNotification("error", "Bitte lade eine ZIP-Datei hoch");
      return;
    }

    const formData = new FormData();
    formData.append("action", "psycho_upload_styling_plugin");
    formData.append("nonce", psychoWizard.nonce);
    formData.append("file", file);

    window.showNotification("info", "Plugin wird installiert...");

    $.ajax({
      url: psychoWizard.ajaxUrl,
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showFileUploaded("stylingPluginUpload", file.name);
          if (typeof markStepCompleted === "function") {
            window.markStepCompleted(8);
          }
          // Update progress bubble immediately
          $(`.step[data-step="8"]`).addClass("completed");
          window.updateButtons();
          window.showNotification("success", response.data.message);
        } else {
          window.showNotification("error", response.data.message);
        }
      },
      error: function () {
        window.showNotification("error", "Upload fehlgeschlagen");
      },
    });
  };

  function setupUploadArea(areaId, fileKey, callback) {
    const $area = $("#" + areaId);
    if (!$area.length) return;

    // Click to upload
    $area.on("click", function () {
      const input = $('<input type="file">');
      input.on("change", function (e) {
        if (e.target.files[0]) {
          callback(e.target.files[0]);
        }
      });
      input.click();
    });

    // Drag & Drop
    $area.on("dragover", function (e) {
      e.preventDefault();
      $(this).addClass("dragover");
    });

    $area.on("dragleave", function () {
      $(this).removeClass("dragover");
    });

    $area.on("drop", function (e) {
      e.preventDefault();
      $(this).removeClass("dragover");

      if (e.originalEvent.dataTransfer.files[0]) {
        callback(e.originalEvent.dataTransfer.files[0]);
      }
    });
  }

  function showFileUploaded(areaId, fileName) {
    $("#" + areaId).html(`
            <div class="file-uploaded">
                <div class="file-uploaded-icon">✓</div>
                <div class="file-uploaded-name">${fileName}</div>
            </div>
        `);
  }

  // AJAX Upload Functions
  function uploadElementorPro(file) {
    const formData = new FormData();
    formData.append("action", "psycho_upload_elementor_pro");
    formData.append("nonce", psychoWizard.nonce);
    formData.append("file", file);

    window.showNotification(
      "info",
      "Elementor Pro wird hochgeladen... Dies kann einen Moment dauern."
    );

    $.ajax({
      url: psychoWizard.ajaxUrl,
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          uploadedFiles.elementorPro = true;
          showFileUploaded("proUpload", file.name);

          // Zeige Lizenz-Aktivierungs-Sektion
          $("#licenseActivationSection").slideDown();

          window.showNotification(
            "success",
            response.data.message + " - Aktiviere jetzt deine Lizenz."
          );
        } else {
          window.showNotification("error", response.data.message);
        }
      },
      error: function () {
        window.showNotification(
          "error",
          "Upload fehlgeschlagen. Bitte versuche es erneut."
        );
      },
    });
  }

  // Template Kit Import Status prüfen
  window.checkTemplateKitImport = function () {
    const $btn = $("#checkImportBtn");
    const $statusDisplay = $("#importStatusDisplay");
    const $statusText = $("#importStatusText");

    $btn.prop("disabled", true).text("⏳ Checking import...");
    $statusDisplay.hide();

    $.ajax({
      url: psychoWizard.ajaxUrl,
      type: "POST",
      data: {
        action: "psycho_check_template_import",
        nonce: psychoWizard.nonce,
      },
      success: function (response) {
        console.log("Template import check response:", response);
        $btn
          .prop("disabled", false)
          .text(psychoWizard.i18n.checkImportStatusBtn);

        if (response.success && response.data.has_templates) {
          // Templates wurden gefunden!
          uploadedFiles.templateKit = true;
          $statusDisplay
            .css("background", "#d1fae5")
            .css("border", "2px solid #10b981")
            .show();
          const foundText = psychoWizard.i18n.foundTemplates
            .replace("%d", response.data.template_count)
            .replace("%d", response.data.page_count);
          $statusText.html(
            psychoWizard.i18n.templateKitImported + "<br>" + foundText
          );

          // Markiere Step 5 als abgeschlossen
          window.markStepCompleted(5);

          // Aktualisiere Progress Bar visuell
          $(`.step[data-step="5"]`).addClass("completed");

          window.updateButtons();
          window.showNotification("success", "Template Kit import completed!");
        } else {
          // No templates found yet
          $statusDisplay
            .css("background", "#fef3c7")
            .css("border", "2px solid #f59e0b")
            .show();
          $statusText.html(
            "⚠️ <strong>No templates found yet</strong><br>" +
              "Please import your kit via Elementor first, then check again.<br>" +
              (response.data.message ||
                "No templates or pages found. Please import your kit via Elementor.")
          );
          window.showNotification(
            "error",
            "No templates imported yet. Please perform the import in Elementor first."
          );
        }
      },
      error: function (xhr, status, error) {
        console.error("Template import check error:", xhr.responseText);
        $btn
          .prop("disabled", false)
          .text(psychoWizard.i18n.checkImportStatusBtn);
        window.showNotification(
          "error",
          "Error checking import status: " + error
        );
      },
    });
  };

  /**
   * Auto-Check Template Import (ohne Button)
   */
  function autoCheckTemplateImport() {
    $.ajax({
      url: psychoWizard.ajaxUrl,
      type: "POST",
      data: {
        action: "psycho_check_template_import",
        nonce: psychoWizard.nonce,
      },
      success: function (response) {
        if (response.success && response.data.has_templates) {
          uploadedFiles.templateKit = true;
          window.markStepCompleted(5);
          // Update progress bubble immediately
          $(`.step[data-step="5"]`).addClass("completed");
          window.updateButtons();
          console.log("Template Kit automatisch erkannt:", response.data);
          // Show subtle notification
          window.showNotification("success", "Template Kit detected! ✓");
        }
      },
    });
  }

  // Button-Click Event für Elementor Import tracken
  $(document).on("click", "#openElementorImport", function () {
    // Speichere dass User den Import geöffnet hat
    localStorage.setItem("psycho_wizard_import_opened", "true");
  });

  // Auto-Check wenn User zurück zum Wizard Tab kommt (Step 5)
  document.addEventListener("visibilitychange", function () {
    if (!document.hidden && currentStep === 5) {
      // User ist zurück zum Wizard Tab auf Step 5
      const importOpened = localStorage.getItem("psycho_wizard_import_opened");
      if (importOpened === "true" && !uploadedFiles.templateKit) {
        console.log("Auto-checking template import...");
        // Warte kurz damit Elementor Zeit hat zu speichern
        setTimeout(function () {
          autoCheckTemplateImport();
        }, 1000);
      }
    }
  });
  window.checkElementorProLicense = function () {
    const $btn = $("#checkLicenseBtn");
    const $statusDisplay = $("#licenseStatusDisplay");
    const $statusText = $("#licenseStatusText");

    $btn.prop("disabled", true).text(psychoWizard.i18n.checkingLicense);
    $statusDisplay.hide();

    $.ajax({
      url: psychoWizard.ajaxUrl,
      type: "POST",
      data: {
        action: "psycho_check_elementor_license",
        nonce: psychoWizard.nonce,
      },
      success: function (response) {
        console.log("License check response:", response); // Debug
        $btn
          .prop("disabled", false)
          .text(psychoWizard.i18n.checkLicenseStatusBtn);

        if (response.success && response.data.is_active) {
          // License is active!
          const wasAlreadyActive = uploadedFiles.elementorProActivated;
          uploadedFiles.elementorProActivated = true;
          $statusDisplay
            .css("background", "#d1fae5")
            .css("border", "2px solid #10b981")
            .show();
          $statusText.html(
            "✅ <strong>License active!</strong> You can now proceed."
          );
          window.updateButtons();

          if (wasAlreadyActive) {
            window.showNotification(
              "success",
              "✓ Status checked - License is still active!"
            );
          } else {
            window.showNotification(
              "success",
              "Elementor Pro license successfully activated!"
            );
          }
        } else {
          // License not yet active
          $statusDisplay
            .css("background", "#fee2e2")
            .css("border", "2px solid #ef4444")
            .show();
          $statusText.html(
            "❌ <strong>License not yet active</strong><br>Please activate Elementor Pro via the link above and check again."
          );
          window.showNotification(
            "error",
            "License not yet activated. Please activate it first."
          );
        }
      },
      error: function (xhr, status, error) {
        console.error("License check error:", xhr.responseText); // Debug
        $btn
          .prop("disabled", false)
          .text(psychoWizard.i18n.checkLicenseStatusBtn);
        window.showNotification(
          "error",
          "Error checking license status: " + error
        );
      },
    });
  };

  function uploadTemplateKit(file) {
    // Prüfe Dateityp
    if (!file.name.endsWith(".zip")) {
      window.showNotification(
        "error",
        "Bitte lade eine ZIP-Datei hoch (Elementor Website Kit)"
      );
      return;
    }

    // Prüfe Dateigröße (max 50MB)
    const maxSize = 50 * 1024 * 1024; // 50MB
    if (file.size > maxSize) {
      window.showNotification("error", "Datei ist zu groß. Maximum: 50MB");
      return;
    }

    const formData = new FormData();
    formData.append("action", "psycho_upload_template_kit");
    formData.append("nonce", psychoWizard.nonce);
    formData.append("file", file);

    window.showNotification(
      "info",
      "Template Kit wird hochgeladen und importiert... Dies kann 1-3 Minuten dauern."
    );

    // Button deaktivieren während Upload
    const $nextBtn = $("#nextBtn");
    $nextBtn.prop("disabled", true).text("⏳ Import läuft...");

    $.ajax({
      url: psychoWizard.ajaxUrl,
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      timeout: 300000, // 5 Minuten Timeout
      success: function (response) {
        $nextBtn.prop("disabled", false);

        if (response.success) {
          uploadedFiles.templateKit = true;
          showFileUploaded("templateUpload", file.name);
          window.updateButtons();
          window.showNotification("success", response.data.message);
        } else {
          window.showNotification("error", response.data.message);
          window.updateButtons();
        }
      },
      error: function (xhr, status, error) {
        $nextBtn.prop("disabled", false);
        window.updateButtons();

        if (status === "timeout") {
          window.showNotification(
            "error",
            "Upload-Timeout. Die Datei ist zu groß oder der Server zu langsam."
          );
        } else {
          window.showNotification("error", "Upload fehlgeschlagen: " + error);
        }
      },
    });
  }

  function uploadAcfJson(file) {
    const formData = new FormData();
    formData.append("action", "psycho_upload_acf_json");
    formData.append("nonce", psychoWizard.nonce);
    formData.append("file", file);

    $.ajax({
      url: psychoWizard.ajaxUrl,
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          uploadedFiles.acfJson = true;
          showFileUploaded("acfUpload", file.name);
          // Mark step as completed and update progress bubble immediately
          window.markStepCompleted(6);
          $(`.step[data-step="6"]`).addClass("completed");
          window.updateButtons();
          window.showNotification("success", response.data.message);

          // WICHTIG: Seite neu laden um Custom Post Type im Admin-Menü anzuzeigen
          // Das WordPress Admin-Menü wird nur beim Page-Load generiert
          window.showNotification(
            "info",
            "🔄 Seite wird neu geladen um den Custom Post Type anzuzeigen..."
          );

          setTimeout(function () {
            location.reload();
          }, 2500); // 2.5 Sekunden Wartezeit
        } else {
          window.showNotification("error", response.data.message);
        }
      },
    });
  }

  function uploadDemoData(file) {
    const formData = new FormData();
    formData.append("action", "psycho_upload_demo_data");
    formData.append("nonce", psychoWizard.nonce);
    formData.append("file", file);

    $.ajax({
      url: psychoWizard.ajaxUrl,
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          uploadedFiles.demoData = true;
          showFileUploaded("demoUpload", file.name);
          window.showNotification("success", response.data.message);
        } else {
          window.showNotification("error", response.data.message);
        }
      },
    });
  }

  function uploadLogo(file) {
    const formData = new FormData();
    formData.append("action", "wp_handle_upload");
    formData.append("file", file);

    // Nutze WordPress Media Uploader
    // Alternativ: Custom Upload Handler

    uploadedFiles.logo = true;
    showFileUploaded("logoUpload", file.name);
    window.showNotification("success", "Logo hochgeladen");
  }

  // Installation Functions
  function installTheme(elementId) {
    const $el = $("#" + elementId);
    $el.removeClass("status-pending").addClass("status-installing");
    $el.html('<span class="installing-animation"></span> Installiere...');

    $.ajax({
      url: psychoWizard.ajaxUrl,
      type: "POST",
      data: {
        action: "psycho_install_hello_theme",
        nonce: psychoWizard.nonce,
      },
      success: function (response) {
        if (response.success) {
          $el.removeClass("status-installing").addClass("status-installed");
          $el.text(psychoWizard.i18n.installed);

          // Speichere dass Step 2 abgeschlossen ist
          window.markStepCompleted(2);

          setTimeout(() => window.nextStep(), 500);
        } else {
          $el.removeClass("status-installing").addClass("status-pending");
          $el.text("Fehler");
          window.showNotification("error", response.data.message);
        }
      },
    });
  }

  function installPlugin(elementId, action) {
    const $el = $("#" + elementId);
    $el.removeClass("status-pending").addClass("status-installing");
    $el.html('<span class="installing-animation"></span> Installiere...');

    $.ajax({
      url: psychoWizard.ajaxUrl,
      type: "POST",
      data: {
        action: action || "psycho_install_elementor",
        nonce: psychoWizard.nonce,
      },
      success: function (response) {
        if (response.success) {
          $el.removeClass("status-installing").addClass("status-installed");
          $el.text(psychoWizard.i18n.installed);

          // WICHTIG: Step 3 (Elementor) wird NICHT als completed markiert
          // weil der Status dynamisch geprüft wird (nur grün wenn aktiv)
          // Step 8 wird markiert da Styling Plugin nicht deaktiviert werden sollte
          if (action === "psycho_install_styling_plugin") {
            window.markStepCompleted(8);
          }

          setTimeout(() => window.nextStep(), 500);
        } else {
          $el.removeClass("status-installing").addClass("status-pending");
          $el.text("Fehler");
          window.showNotification("error", response.data.message);
        }
      },
    });
  }

  /**
   * Markiere Step als abgeschlossen (bereits global exponiert am Anfang)
   */
  // Funktion existiert bereits als window.markStepCompleted

  function activateLicense() {
    const licenseKey = $("#proLicense").val();

    if (!licenseKey) {
      window.showNotification("error", "Bitte Lizenzschlüssel eingeben");
      return;
    }

    // Button deaktivieren während der Aktivierung
    const $nextBtn = $("#nextBtn");
    const originalText = $nextBtn.text();
    $nextBtn.prop("disabled", true).text("Lizenz wird aktiviert...");

    $.ajax({
      url: psychoWizard.ajaxUrl,
      type: "POST",
      data: {
        action: "psycho_activate_license",
        nonce: psychoWizard.nonce,
        license_key: licenseKey,
      },
      success: function (response) {
        $nextBtn.prop("disabled", false).text(originalText);

        if (response.success) {
          window.showNotification("success", response.data.message);
          // Warte 2 Sekunden damit User die Nachricht lesen kann
          setTimeout(() => {
            window.nextStep();
          }, 2000);
        } else {
          window.showNotification("error", response.data.message);
        }
      },
      error: function (xhr, status, error) {
        $nextBtn.prop("disabled", false).text(originalText);
        window.showNotification(
          "error",
          "Fehler bei der Lizenzaktivierung: " + error
        );
      },
    });
  }

  let isApplyingColors = false; // Flag um Mehrfach-Aufrufe zu verhindern

  // Neue Funktion: Farben sofort anwenden ohne Auto-Advance (wie Step 15)
  function applyColorsImmediately() {
    if (!selectedScheme || isApplyingColors) return;

    isApplyingColors = true;

    const colors = colorSchemes[selectedScheme].colors;
    const data = {
      action: "psycho_set_colors",
      nonce: psychoWizard.nonce,
      scheme: selectedScheme,
    };

    // 10 Farben übergeben
    colors.forEach((color, index) => {
      data["color_" + (index + 1)] = color;
    });

    window.showNotification("info", "🎨 Farbschema wird angewendet...");

    $.ajax({
      url: psychoWizard.ajaxUrl,
      type: "POST",
      data: data,
      success: function (response) {
        isApplyingColors = false;
        $(".color-scheme").removeClass("applying");

        if (response.success) {
          // Active Klasse ist bereits gesetzt (optimistic update)
          // Stelle sicher, dass nur das gewählte Schema aktiv ist
          $(".color-scheme").removeClass("active");
          $(`.color-scheme[data-scheme="${selectedScheme}"]`).addClass(
            "active"
          );

          // Entferne "Eigenes Farbschema aktiv" Info-Box falls vorhanden
          $("#colorSchemesContainer > .info-box").remove();

          window.showNotification(
            "success",
            "✅ Farbschema erfolgreich angewendet!"
          );

          // Markiere Step 13 als abgeschlossen
          window.markStepCompleted(13);
          // Update progress bubble immediately
          $(`.step[data-step="13"]`).addClass("completed");

          // KEIN Auto-Advance - User bleibt auf Step 13 (wie bei Step 15)
          window.updateButtons();
        } else {
          // Fehler - entferne active Klasse wieder
          $(`.color-scheme[data-scheme="${selectedScheme}"]`).removeClass(
            "active"
          );
          window.showNotification(
            "error",
            response.data.message || "Fehler beim Anwenden der Farben"
          );
        }
      },
      error: function (xhr, status, error) {
        isApplyingColors = false;
        $(".color-scheme").removeClass("applying");
        // Fehler - entferne active Klasse vom fehlgeschlagenen Schema
        $(`.color-scheme[data-scheme="${selectedScheme}"]`).removeClass(
          "active"
        );
        window.showNotification(
          "error",
          "Fehler beim Anwenden der Farben: " + error
        );
        console.error("Color application error:", xhr.responseText);
      },
    });
  }

  // Legacy Funktion für "Next" Button - falls noch verwendet
  function applyColors() {
    if (!selectedScheme || isApplyingColors) return;

    isApplyingColors = true;

    // Deaktiviere den Next-Button während der Verarbeitung
    const $nextBtn = $("#nextBtn");
    const originalText = $nextBtn.text();
    $nextBtn.prop("disabled", true).text(psychoWizard.i18n.applyingColors);

    const colors = colorSchemes[selectedScheme].colors;
    const data = {
      action: "psycho_set_colors",
      nonce: psychoWizard.nonce,
      scheme: selectedScheme, // Schema-Name mitsenden
    };

    // 10 Farben übergeben
    colors.forEach((color, index) => {
      data["color_" + (index + 1)] = color;
    });

    window.showNotification(
      "info",
      "🎨 Farbschema wird angewendet, dies kann einen Moment dauern..."
    );

    $.ajax({
      url: psychoWizard.ajaxUrl,
      type: "POST",
      data: data,
      success: function (response) {
        isApplyingColors = false;
        $nextBtn.prop("disabled", false).text(originalText);

        if (response.success) {
          // Markiere gewähltes Schema als aktiv
          $(".color-scheme").removeClass("active");
          $(`.color-scheme[data-scheme="${selectedScheme}"]`).addClass(
            "active"
          );

          // Entferne "Eigenes Farbschema aktiv" Info-Box falls vorhanden
          $("#colorSchemesContainer > .info-box").remove();

          window.showNotification(
            "success",
            "✓ Alle 17 Farben erfolgreich angewendet!"
          );

          // Markiere Step 13 als abgeschlossen
          window.markStepCompleted(13);
          // Update progress bubble immediately
          $(`.step[data-step="13"]`).addClass("completed");

          // Kurze Pause damit User die Erfolgsmeldung sieht
          setTimeout(function () {
            currentStep++;
            updateSteps();
            updateProgress();
            window.updateButtons();
          }, 1500);
        } else {
          window.showNotification(
            "error",
            response.data.message || "Fehler beim Anwenden der Farben"
          );
        }
      },
      error: function (xhr, status, error) {
        isApplyingColors = false;
        $nextBtn.prop("disabled", false).text(originalText);
        window.showNotification(
          "error",
          "Fehler beim Anwenden der Farben: " + error
        );
        console.error("Color application error:", xhr.responseText);
      },
    });
  }

  function uploadFonts() {
    const formData = new FormData();
    formData.append("action", "psycho_upload_fonts");
    formData.append("nonce", psychoWizard.nonce);

    if (uploadedFiles.headingFont) {
      formData.append("heading_font", uploadedFiles.headingFont);
    }

    if (uploadedFiles.bodyFont) {
      formData.append("body_font", uploadedFiles.bodyFont);
    }

    $.ajax({
      url: psychoWizard.ajaxUrl,
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          window.showNotification("success", "Fonts erfolgreich hochgeladen");
          window.nextStep();
        } else {
          window.showNotification("error", response.data.message);
        }
      },
    });
  }

  function completeWizard() {
    $.ajax({
      url: psychoWizard.ajaxUrl,
      type: "POST",
      data: {
        action: "psycho_complete_wizard",
        nonce: psychoWizard.nonce,
      },
      success: function (response) {
        if (response.success) {
          window.showNotification(
            "success",
            "✅ Setup erfolgreich abgeschlossen!"
          );
          // KEIN Redirect - bleibe auf Step 16 (Abschluss-Seite)
          // User kann manuell zum Theme Builder über den Button gehen
        }
      },
    });
  }

  // Navigation (überschreibt globale window.nextStep)
  window.nextStep = function () {
    // Check for actions that need to be performed
    if (currentStep === 2 && $("#helloTheme").text() === "Bereit") {
      installTheme("helloTheme");
      return;
    }

    if (currentStep === 3 && $("#elementor").text() === "Bereit") {
      installPlugin("elementor", "psycho_install_elementor");
      return;
    }

    if (
      currentStep === 4 &&
      uploadedFiles.elementorPro &&
      $("#proLicense").val()
    ) {
      activateLicense();
      return;
    }

    if (currentStep === 8 && $("#stylingPlugin").text() === "Bereit") {
      installPlugin("stylingPlugin", "psycho_install_styling_plugin");
      return;
    }

    // Step 13: Farben werden jetzt sofort beim Klick angewendet - Next-Button springt nur weiter
    // (Alte applyColors() Logik entfernt)

    // Step 14 (Typography) hat keine Blocker mehr - normale Navigation
    // Step 15 wird als nächster angezeigt

    // Step 16 ist der letzte Step - kein weiterer Schritt mehr
    if (currentStep === 16) {
      // Wizard ist abgeschlossen, markiere Status
      completeWizard();
      // Aber bleibe auf Step 16, kein Redirect
      return;
    }

    if (currentStep < totalSteps) {
      currentStep++;
      updateSteps(); // Scrollt automatisch nach oben
      updateProgress();
      window.updateButtons();
    }
  };

  function previousStep() {
    if (currentStep > 1) {
      currentStep--;
      updateSteps(); // Scrollt automatisch nach oben
      updateProgress();
      window.updateButtons();
    }
  }

  function updateProgress() {
    const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
    $("#progressFill").css("width", progress + "%");
  }

  function updateSteps() {
    $(".step").each(function () {
      const stepNum = parseInt($(this).data("step"));

      // Entferne nur 'active' Klasse, NICHT 'completed'
      $(this).removeClass("active");

      if (stepNum === currentStep) {
        $(this).addClass("active");
      }
      // WICHTIG: completed Klasse wird NUR von loadWizardStatus() gesetzt
      // basierend darauf ob der Step wirklich abgeschlossen wurde
      // NICHT automatisch für alle Steps vor currentStep
    });

    $(".wizard-step").removeClass("active");
    $(`.wizard-step[data-step="${currentStep}"]`).addClass("active");

    // Setup Upload-Handler für Step-spezifische Upload-Areas
    setupStepUploads();

    // WICHTIG: Scroll-Verhalten optimiert für lange Steps
    // Warte kurz damit DOM aktualisiert ist, dann scroll nach oben
    setTimeout(function () {
      // Finde den RICHTIGEN Scroll-Container (wizard-body, nicht window!)
      const $wizardBody = $(".wizard-body");

      if ($wizardBody.length) {
        // Scroll den wizard-body Container nach oben (smooth)
        $wizardBody.animate(
          {
            scrollTop: 0,
          },
          400
        );

        console.log("Scrolled wizard-body to top");
      } else {
        // Fallback: Scroll window (falls wizard-body nicht gefunden)
        window.scrollTo({
          top: 0,
          left: 0,
          behavior: "smooth",
        });
        console.warn("wizard-body not found, scrolling window instead");
      }

      // Optional: Scroll active step bubble into view (horizontal only)
      // Aber NICHT vertikal scrollen, damit wir oben bleiben
      setTimeout(function () {
        const $activeStep = $(".step.active");
        if ($activeStep.length) {
          // Nur horizontal scrollen für die Bubble, nicht vertikal
          $activeStep[0].scrollIntoView({
            behavior: "smooth",
            inline: "center",
            block: "nearest", // Verhindert vertikales Scrollen
          });
        }
      }, 450);
    }, 50);
  }

  // Setup Upload-Handler für aktuellen Step
  function setupStepUploads() {
    // Step 6: ACF JSON
    if (
      currentStep === 6 &&
      $("#acfUpload").length &&
      !$("#acfUpload").data("upload-ready")
    ) {
      console.log("Setting up ACF upload area");
      $("#acfUpload").data("upload-ready", true);
      setupUploadArea("acfUpload", "acfJson", function (file) {
        uploadAcfJson(file);
      });
    }

    // Step 7: Demo Data
    if (
      currentStep === 7 &&
      $("#demoUpload").length &&
      !$("#demoUpload").data("upload-ready")
    ) {
      console.log("Setting up Demo Data upload area");
      $("#demoUpload").data("upload-ready", true);
      setupUploadArea("demoUpload", "demoData", function (file) {
        uploadDemoData(file);
      });
    }

    // Step 8: Styling Plugin
    if (
      currentStep === 8 &&
      $("#stylingPluginUpload").length &&
      !$("#stylingPluginUpload").data("upload-ready")
    ) {
      console.log("Setting up Styling Plugin upload area");
      $("#stylingPluginUpload").data("upload-ready", true);
      setupUploadArea("stylingPluginUpload", "stylingPlugin", function (file) {
        uploadStylingPlugin(file);
      });
    }

    // Step 9: Demo Data
    // Handler wird in step-9.php selbst registriert (wegen Reset-Funktionalität)
    if (currentStep === 9 && $("#importDemoCheckbox").length) {
      // Nur einmalig beim ersten Laden registrieren, nicht nach Reset
      if (!$("#importDemoCheckbox").data("handler-registered")) {
        $("#importDemoCheckbox").data("handler-registered", true);

        $("#importDemoCheckbox").on("change", function () {
          if (this.checked) {
            $("#demoUploadSection").slideDown();
            $("#skipDemoBtn").hide();
            if (
              $("#demoDataUpload").length &&
              !$("#demoDataUpload").data("upload-ready")
            ) {
              console.log("Setting up Demo Data upload area");
              $("#demoDataUpload").data("upload-ready", true);
              setupUploadArea("demoDataUpload", "demoData", function (file) {
                uploadDemoData(file);
              });
            }
          } else {
            $("#demoUploadSection").slideUp();
            $("#skipDemoBtn").show();
          }
        });
      }
    }

    // Step 10: Logo Upload
    if (
      currentStep === 10 &&
      $("#logoUploadArea").length &&
      !$("#logoUploadArea").data("upload-ready")
    ) {
      console.log("Setting up Logo upload area");
      $("#logoUploadArea").data("upload-ready", true);
      setupUploadArea("logoUploadArea", "logo", function (file) {
        window.logoFile = file;
        showFileUploaded("logoUploadArea", file.name);
      });
    }

    // Step 12: Font Uploads
    if (currentStep === 12) {
      if (
        $("#headingFontUpload").length &&
        !$("#headingFontUpload").data("upload-ready")
      ) {
        console.log("Setting up Heading Font upload area");
        $("#headingFontUpload").data("upload-ready", true);
        setupUploadArea("headingFontUpload", "headingFont", function (file) {
          uploadedFiles.headingFont = file;
          showFileUploaded("headingFontUpload", file.name);
          window.updateButtons();
        });
      }

      if (
        $("#bodyFontUpload").length &&
        !$("#bodyFontUpload").data("upload-ready")
      ) {
        console.log("Setting up Body Font upload area");
        $("#bodyFontUpload").data("upload-ready", true);
        setupUploadArea("bodyFontUpload", "bodyFont", function (file) {
          uploadedFiles.bodyFont = file;
          showFileUploaded("bodyFontUpload", file.name);
          window.updateButtons();
        });
      }
    }

    // Step 13: Aktives Farbschema erkennen und markieren
    if (currentStep === 13) {
      // Entferne alte Markierungen
      $(".color-scheme").removeClass("active");
      $("#colorSchemesContainer > .info-box").remove();

      console.log("Lade aktives Farbschema...");

      // Hole gespeichertes aktives Schema via AJAX
      $.ajax({
        url: psychoWizard.ajaxUrl,
        type: "POST",
        data: {
          action: "psycho_get_active_color_scheme",
          nonce: psychoWizard.nonce,
        },
        success: function (response) {
          if (response.success && response.data.scheme) {
            const activeScheme = response.data.scheme;
            console.log("✅ Gespeichertes Farbschema gefunden:", activeScheme);

            // Markiere das aktive Schema
            $(`.color-scheme[data-scheme="${activeScheme}"]`).addClass(
              "active"
            );
            selectedScheme = activeScheme;

            window.updateButtons();
          } else {
            console.log(
              "ℹ️ Kein gespeichertes Schema gefunden - versuche Fallback-Erkennung..."
            );

            // FALLBACK: Versuche Schema durch Farbvergleich zu erkennen
            $.ajax({
              url: psychoWizard.ajaxUrl,
              type: "POST",
              data: {
                action: "psycho_get_current_colors",
                nonce: psychoWizard.nonce,
              },
              success: function (colorResponse) {
                if (colorResponse.success && colorResponse.data.colors) {
                  const currentColors = colorResponse.data.colors;
                  console.log("Aktuelle Farben aus DB:", currentColors);

                  // Vergleiche mit allen Schemas
                  let matchedScheme = null;
                  for (const [schemeKey, schemeData] of Object.entries(
                    colorSchemes
                  )) {
                    const schemeColors = schemeData.colors;

                    // Vergleiche die ersten 10 Farben (case-insensitive)
                    let matches = 0;
                    for (let i = 0; i < 10; i++) {
                      if (currentColors[i] && schemeColors[i]) {
                        if (
                          currentColors[i].toUpperCase() ===
                          schemeColors[i].toUpperCase()
                        ) {
                          matches++;
                        }
                      }
                    }

                    console.log(
                      `Schema "${schemeKey}": ${matches}/10 Farben übereinstimmend`
                    );

                    // Wenn alle 10 übereinstimmen = Schema gefunden
                    if (matches === 10) {
                      matchedScheme = schemeKey;
                      break;
                    }
                  }

                  if (matchedScheme) {
                    console.log(
                      "✅ Schema durch Farbvergleich erkannt:",
                      matchedScheme
                    );
                    $(`.color-scheme[data-scheme="${matchedScheme}"]`).addClass(
                      "active"
                    );
                    selectedScheme = matchedScheme;

                    // Speichere das erkannte Schema für die Zukunft
                    $.ajax({
                      url: psychoWizard.ajaxUrl,
                      type: "POST",
                      data: {
                        action: "psycho_set_colors",
                        nonce: psychoWizard.nonce,
                        scheme: matchedScheme,
                        ...currentColors.reduce((acc, color, i) => {
                          acc[`color_${i + 1}`] = color;
                          return acc;
                        }, {}),
                      },
                    });
                  } else {
                    console.log("⚠️ Kein Schema gefunden - Custom Farben");
                    // Zeige "Custom Farben aktiv" Hinweis
                    $("#colorSchemesContainer").prepend(`
                                            <div class="info-box" style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; margin-bottom: 20px; border-radius: 8px;">
                                                <div class="info-box-content" style="color: #92400e;">
                                                    <strong>🎨 Eigenes Farbschema aktiv</strong><br>
                                                    Deine aktuellen Global Colors wurden individuell angepasst. Du kannst jederzeit ein Schema wählen um die Farben zu ändern.
                                                </div>
                                            </div>
                                        `);
                    selectedScheme = null;
                  }
                }

                window.updateButtons();
              },
              error: function () {
                console.error("Fehler bei Fallback-Erkennung");
                window.updateButtons();
              },
            });
          }
        },
        error: function (xhr, status, error) {
          console.error("❌ Fehler beim Laden des aktiven Schemas:", error);
          window.updateButtons();
        },
      });
    }

    // Step 14: Aktives Typography-Schema erkennen und markieren
    if (currentStep === 14) {
      // Entferne alte Markierungen
      $(".typography-scheme").removeClass("active");

      console.log("Lade aktives Typography-Schema...");

      // Hole gespeichertes aktives Typography-Schema via AJAX
      $.ajax({
        url: psychoWizard.ajaxUrl,
        type: "POST",
        data: {
          action: "psycho_get_active_typography_scheme",
          nonce: psychoWizard.nonce,
        },
        success: function (response) {
          if (response.success && response.data.scheme) {
            const activeScheme = response.data.scheme;
            console.log("Aktives Typography-Schema:", activeScheme);

            // Markiere das aktive Schema
            $(`.typography-scheme[data-scheme="${activeScheme}"]`).addClass(
              "active"
            );
          } else {
            console.log("Kein gespeichertes Typography-Schema gefunden");
          }

          window.updateButtons();
        },
        error: function (xhr, status, error) {
          console.error(
            "Fehler beim Laden des aktiven Typography-Schemas:",
            error
          );
          window.updateButtons();
        },
      });
    }
  }

  window.updateButtons = function () {
    const $prevBtn = $("#prevBtn");
    const $nextBtn = $("#nextBtn");

    $prevBtn.css("visibility", currentStep === 1 ? "hidden" : "visible");

    // Button standardmäßig anzeigen (wird nur in Step 16 versteckt)
    $nextBtn.show();

    let canProceed = true;
    let buttonText = psychoWizard.i18n.nextBtn;

    switch (currentStep) {
      case 1:
        // Welcome: "Los geht's →" / "Let's Go →"
        buttonText = psychoWizard.i18n.startBtn;
        break;
      case 4:
        // Elementor Pro: Nur weiter wenn Lizenz aktiv
        canProceed =
          uploadedFiles.elementorPro && uploadedFiles.elementorProActivated;
        buttonText = uploadedFiles.elementorProActivated
          ? psychoWizard.i18n.nextBtn
          : psychoWizard.i18n.pleasActivateLicenseBtn;
        break;
      case 5:
        // Template Kit: Nur weiter wenn importiert
        canProceed = uploadedFiles.templateKit;
        buttonText = uploadedFiles.templateKit
          ? psychoWizard.i18n.nextBtn
          : psychoWizard.i18n.pleaseImportTemplateKitBtn;
        break;
      case 6:
        // ACF: Nur weiter wenn hochgeladen
        canProceed = uploadedFiles.acfJson;
        break;
      case 13:
        // Farbenschema: Immer erlaubt - Farben werden jetzt sofort beim Klick angewendet
        canProceed = true;
        buttonText = psychoWizard.i18n.nextBtn; // Einfach "Weiter" / "Next"
        break;
      case 15:
        // Styles: Optional, kann übersprungen werden
        canProceed = true;
        buttonText = psychoWizard.i18n.continueStylesOptionalBtn;
        break;
      case 16:
        // Fertig: Setup abgeschlossen
        canProceed = false;
        buttonText = psychoWizard.i18n.setupCompletedBtn;
        $nextBtn.hide(); // Verstecke den Button
        break;
      // Alle anderen Steps (2,3,7,8,9,10,11,12,14): Default "Weiter →" / "Next →"
    }

    $nextBtn.prop("disabled", !canProceed);
    $nextBtn.text(buttonText);
  };

  function previewScheme(scheme) {
    const colors = colorSchemes[scheme].colors;
    const $preview = $("#demoPreview");
    $preview.show();

    $("#previewBox").css(
      "background",
      `linear-gradient(135deg, ${colors[0]} 0%, ${colors[1]} 100%)`
    );
    $("#previewText1").css("background", colors[2]);
    $("#previewText2").css("background", colors[2]);
    $("#previewText3").css("background", colors[2]);

    $preview[0].scrollIntoView({ behavior: "smooth", block: "nearest" });
  }

  // Typography Scheme anwenden
  $(document).on("click", ".typography-scheme", function () {
    const scheme = $(this).data("scheme");
    const schemeData = typographySchemes[scheme];

    if (!schemeData) {
      showNotification("❌ Typography Scheme nicht gefunden", "error");
      return;
    }

    // Visual Feedback
    $(".typography-scheme").removeClass("active");
    $(this).addClass("active");

    showNotification("⏳ Schriftarten werden angewendet...", "info");

    $.ajax({
      url: psychoWizard.ajaxUrl,
      method: "POST",
      data: {
        action: "psycho_apply_typography",
        nonce: psychoWizard.nonce,
        scheme: scheme,
        fonts: schemeData.fonts,
      },
      success: function (response) {
        if (response.success) {
          showNotification(
            "✅ " +
              (response.data?.message || "Schriftarten erfolgreich geändert!"),
            "success"
          );

          // Markiere Step 14 als abgeschlossen
          window.markStepCompleted(14);

          // KEIN Auto-Jump - User bleibt auf Step 14 (wie bei Step 15)
          window.updateButtons();
        } else {
          showNotification(
            "❌ Fehler: " + (response.data?.message || "Unbekannter Fehler"),
            "error"
          );
          $('.typography-scheme[data-scheme="' + scheme + '"]').removeClass(
            "active"
          );
        }
      },
      error: function () {
        showNotification(
          "❌ Verbindungsfehler beim Anwenden der Schriftarten",
          "error"
        );
        $('.typography-scheme[data-scheme="' + scheme + '"]').removeClass(
          "active"
        );
      },
    });
  });
})(jQuery);
