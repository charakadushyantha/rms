/**
 * Enhanced Login Page Script
 * Adds dark mode, language switcher, and accessibility features
 * Add this after your jQuery import
 */

$(document).ready(function() {
    // Add the UI elements for the enhancements
    addEnhancementUI();
    
    // Setup theme toggle functionality
    setupThemeToggle();
    
    // Setup language switcher
    setupLanguageSwitcher();
    
    // Setup accessibility features
    setupAccessibilityFeatures();
    
    // Setup event listeners for dropdowns
    setupDropdownEvents();
  });
  
  // Add the UI elements for enhancements
  function addEnhancementUI() {
    // Add skip link for accessibility
    $('body').prepend('<a href="#login-form" class="skip-link">Skip to login form</a>');
    
    // Add top controls for dark mode, language, and accessibility
    $('.login-form-container').prepend(`
      <div class="top-controls">
        <button type="button" id="theme-toggle" class="btn-control" aria-label="Toggle dark mode">
          <i class="fas fa-moon"></i>
        </button>
        
        <div class="dropdown">
          <button type="button" id="language-toggle" class="btn-control" aria-label="Change language">
            <i class="fas fa-globe"></i>
          </button>
          <div class="dropdown-menu" id="language-dropdown">
            <div class="dropdown-item" data-lang="en">
              <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/us.svg" alt="English" class="language-flag">
              <span>English</span>
            </div>
            <div class="dropdown-item" data-lang="si">
              <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/lk.svg" alt="Sinhala" class="language-flag">
              <span>සිංහල</span>
            </div>
            <div class="dropdown-item" data-lang="ta">
              <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/lk.svg" alt="Tamil" class="language-flag">
              <span>தமிழ்</span>
            </div>
          </div>
        </div>
        
        <div class="dropdown">
          <button type="button" id="accessibility-toggle" class="btn-control" aria-label="Accessibility options">
            <i class="fas fa-universal-access"></i>
          </button>
          <div class="dropdown-menu" id="accessibility-dropdown">
            <div class="dropdown-item" id="increase-font">
              <i class="fas fa-plus"></i> <span>Increase Text Size</span>
            </div>
            <div class="dropdown-item" id="decrease-font">
              <i class="fas fa-minus"></i> <span>Decrease Text Size</span>
            </div>
            <div class="dropdown-item" id="reset-font">
              <i class="fas fa-undo"></i> <span>Reset Text Size</span>
            </div>
            <div class="dropdown-item" id="high-contrast">
              <i class="fas fa-adjust"></i> <span>High Contrast</span>
            </div>
          </div>
        </div>
      </div>
    `);
    
    // Make the Google login button OAuth ready
    $('.btn-google').attr('href', '<?php echo site_url("OAuth/googleLogin"); ?>');
    $('.btn-google').attr('aria-label', 'Sign in with Google');
    
    // Add ARIA attributes to important elements
    $('form').attr('aria-labelledby', 'loginHeading');
    $('#userid, #userpass').attr('aria-required', 'true');
    $('#userid').attr('autocomplete', 'username');
    $('#userpass').attr('autocomplete', 'current-password');
  }
  
  // Setup theme toggle functionality
  function setupThemeToggle() {
    const themeToggle = document.getElementById('theme-toggle');
    const htmlElement = document.documentElement;
    
    // Check for saved theme preference
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
      htmlElement.setAttribute('data-theme', 'dark');
      themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
    }
    
    // Theme toggle click handler
    themeToggle.addEventListener('click', function() {
      if (htmlElement.getAttribute('data-theme') === 'dark') {
        htmlElement.removeAttribute('data-theme');
        localStorage.setItem('theme', 'light');
        themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
        themeToggle.setAttribute('aria-label', 'Switch to dark mode');
      } else {
        htmlElement.setAttribute('data-theme', 'dark');
        localStorage.setItem('theme', 'dark');
        themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
        themeToggle.setAttribute('aria-label', 'Switch to light mode');
      }
    });
  }
  
  // Setup language switcher
  function setupLanguageSwitcher() {
    // Translation data
    const translations = {
      en: {
        greeting: "Welcome Back",
        instruction: "Enter your details below here",
        username: "Username",
        password: "Password",
        forgotPassword: "Forgot password?",
        signIn: "Sign In",
        or: "or",
        googleSignIn: "Sign in with Google",
        noAccount: "Don't have an account?",
        signUp: "Sign up"
      },
      si: {
        greeting: "ආපසු සාදරයෙන් පිළිගනිමු",
        instruction: "ඔබගේ විස්තර පහත ඇතුළත් කරන්න",
        username: "පරිශීලක නාමය",
        password: "මුරපදය",
        forgotPassword: "මුරපදය අමතක වුණාද?",
        signIn: "පුරන්න",
        or: "හෝ",
        googleSignIn: "Google සමඟ පුරන්න",
        noAccount: "ගිණුමක් නැද්ද?",
        signUp: "ලියාපදිංචි වන්න"
      },
      ta: {
        greeting: "மீண்டும் வரவேற்கிறோம்",
        instruction: "உங்கள் விவரங்களை கீழே உள்ளிடவும்",
        username: "பயனர்பெயர்",
        password: "கடவுச்சொல்",
        forgotPassword: "கடவுச்சொல் மறந்துவிட்டதா?",
        signIn: "உள்நுழைய",
        or: "அல்லது",
        googleSignIn: "Google மூலம் உள்நுழைய",
        noAccount: "கணக்கு இல்லையா?",
        signUp: "பதிவு செய்யுங்கள்"
      }
    };
  
    // Language selection click handlers
    $('.dropdown-item[data-lang]').click(function() {
      const lang = $(this).data('lang');
      changeLanguage(lang, translations);
      
      // Save language preference
      localStorage.setItem('language', lang);
      
      // Hide dropdown
      $('#language-dropdown').removeClass('show');
    });
    
    // Load saved language preference
    const savedLanguage = localStorage.getItem('language');
    if (savedLanguage && translations[savedLanguage]) {
      changeLanguage(savedLanguage, translations);
    }
  }
  
  // Change language function
  function changeLanguage(lang, translations) {
    if (!translations[lang]) return;
    
    const t = translations[lang];
    
    // Update text elements
    $('.welcome-text h3').text(t.greeting);
    $('.welcome-text p').text(t.instruction);
    $('#userid').attr('placeholder', t.username);
    $('#userpass').attr('placeholder', t.password);
    $('.forgot-password a').text(t.forgotPassword);
    $('.btn-login').text(t.signIn);
    $('.or-divider').text(t.or);
    $('.btn-google span').text(t.googleSignIn);
    $('.signup-link').html(`${t.noAccount} <a href="${$('.signup-link a').attr('href')}">${t.signUp}</a>`);
    
    // Change text direction for RTL languages (like Arabic)
    if (lang === 'ar') {
      $('html').attr('dir', 'rtl');
    } else {
      $('html').attr('dir', 'ltr');
    }
    
    // Update HTML lang attribute
    $('html').attr('lang', lang);
  }
  
  // Setup accessibility features
  function setupAccessibilityFeatures() {
    // Font size adjustment
    let currentFontSize = localStorage.getItem('fontSize') || 16;
    document.documentElement.style.setProperty('--font-base', currentFontSize + 'px');
    
    $('#increase-font').click(function() {
      if (currentFontSize < 24) {
        currentFontSize = parseInt(currentFontSize) + 2;
        document.documentElement.style.setProperty('--font-base', currentFontSize + 'px');
        localStorage.setItem('fontSize', currentFontSize);
      }
    });
    
    $('#decrease-font').click(function() {
      if (currentFontSize > 12) {
        currentFontSize = parseInt(currentFontSize) - 2;
        document.documentElement.style.setProperty('--font-base', currentFontSize + 'px');
        localStorage.setItem('fontSize', currentFontSize);
      }
    });
    
    $('#reset-font').click(function() {
      currentFontSize = 16;
      document.documentElement.style.setProperty('--font-base', currentFontSize + 'px');
      localStorage.setItem('fontSize', currentFontSize);
    });
    
    // High contrast mode
    $('#high-contrast').click(function() {
      const htmlElement = document.documentElement;
      if (htmlElement.getAttribute('data-contrast') === 'high') {
        htmlElement.removeAttribute('data-contrast');
        localStorage.removeItem('highContrast');
      } else {
        htmlElement.setAttribute('data-contrast', 'high');
        localStorage.setItem('highContrast', 'true');
      }
    });
    
    // Load saved high contrast preference
    if (localStorage.getItem('highContrast') === 'true') {
      document.documentElement.setAttribute('data-contrast', 'high');
    }
  }
  
  // Setup dropdown menu events
  function setupDropdownEvents() {
    // Toggle dropdowns
    $('#language-toggle').click(function() {
      $('#language-dropdown').toggleClass('show');
      $('#accessibility-dropdown').removeClass('show');
    });
    
    $('#accessibility-toggle').click(function() {
      $('#accessibility-dropdown').toggleClass('show');
      $('#language-dropdown').removeClass('show');
    });
    
    // Close dropdowns when clicking outside
    $(document).click(function(event) {
      if (!$(event.target).closest('.dropdown').length) {
        $('.dropdown-menu').removeClass('show');
      }
    });
  }