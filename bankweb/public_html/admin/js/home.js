// (*) Single page application
PAGES = {};

// Inside main page
PAGES.home = {};
PAGES.home.page = document.querySelector("#home");
PAGES.searchcustomer = {};
PAGES.searchcustomer.page = document.querySelector("#searchcustomer");
PAGES.addcustomer = {};
PAGES.addcustomer.page = document.querySelector("#addcustomer");
PAGES.listaccounts = {};
PAGES.listaccounts.page = document.querySelector("#listaccounts");
PAGES.servicereport = {};
PAGES.servicereport.page = document.querySelector("#servicereport");
PAGES.settings = {};
PAGES.settings.page = document.querySelector("#settings");
PAGES.profile = {};
PAGES.profile.page = document.querySelector("#profile");

var path;

// Navigation
function navigate() {
  window.scrollTo({ top: 0, left: 0 }); // Scroll to 0,0
  // Get the url path in a easy
  path = location.hash.substr(1).toLowerCase().split("/");
  // Find what page to show
  var currentPage = path[0];
  if (!PAGES.hasOwnProperty(currentPage)) {
    if (path[0] === "") {
      currentPage = "home";
    }
  }

  // Hide the previous active page
  for (var page in PAGES) {
    if (PAGES.hasOwnProperty(page)) {
      PAGES[page].page.classList.remove("active");
    }
  }

  // Show the active page and run its custom script
  PAGES[currentPage].page.classList.add("active");
}

// First time loading the page
navigate();

window.onhashchange = navigate;

// (*) Question
// ==> Q1 Search customer
var chosenCustomer = null;
var chosenCSSNInput = document.querySelectorAll('input[name="chosencssn"]');
function selectCustomer() {
  var tableCustomer = document
    .getElementById("qr-1")
    .getElementsByTagName("table")[0];
  if (tableCustomer) {
    var rows = tableCustomer.querySelector("tbody").querySelectorAll("tr");
    rows.forEach((row) => {
      row.addEventListener("click", function () {
        if (chosenCustomer && chosenCustomer != this) {
          chosenCustomer.classList.remove("chose");
        }
        this.classList.toggle("chose");
        // Set chosen customer
        if (chosenCustomer == this) {
          chosenCustomer = null;
          changeChosenCustomer();
        } else {
          chosenCustomer = this;
          var cssn = this.childNodes[1].innerHTML;
          changeChosenCustomer(cssn);
        }
        // Do anything after chose the row
      });
    });
  }
}

// Each time choose a customer, change all CSSN
function changeChosenCustomer(cssn = null) {
  // When click a row in customer table, assign cssn value
  chosenCSSNInput.forEach(function (ele) {
    if (cssn) {
      ele.value = cssn;
    }
  });
}

selectCustomer();

// ==> Q2 Add customer
function addAccount() {
  var radios = document
    .getElementById("addcustomer")
    .querySelectorAll('input[name="accounttype"]');
  for (var i = 0; i < radios.length; i++) {
    radios[i].addEventListener("change", (e) => {
      var inputInRate = document.querySelector('div[name="interestrate"]');
      if (
        (e.target.value == "savingaccount" || e.target.value == "loan") &&
        e.target.checked
      ) {
        if (inputInRate.classList.contains("hide")) {
          inputInRate.classList.remove("hide");
        }
      } else {
        inputInRate.classList.add("hide");
      }
    });
  }
}

addAccount();

// Decorte all message
decorateAllMessage();

// ==> Q4 Filter
function filterChecker() {
  var q4 = document.getElementById("servicereport");
  var listFilterType = ["filtertime", "filterquan"];
  listFilterType.forEach((filtertype) => {
    // get label + input
    var labels = q4.querySelectorAll(`label[name="${filtertype}"]`);
    var inputs = q4.querySelectorAll(`input[name="${filtertype}"]`);
    labels.forEach((label) => {
      label.addEventListener("click", function () {
        var value = label.getAttribute("value");
        // Get the input had the same value
        var input = q4.querySelector(`input[value="${value}"]`);
        labels.forEach((label) => {
          label.classList.remove("bg-gray-400");
          label.classList.remove("border-opacity-100");
          label.classList.remove("border-gray-900");
          label.classList.remove("text-gray-900");
        });
        // There's 2 case
        // - If it's not checked
        if (!input.checked) {
          input.checked = true;
          label.classList.toggle("bg-gray-400");
          label.classList.toggle("border-opacity-100");
          label.classList.toggle("border-gray-900");
          label.classList.toggle("text-gray-900");
        }
        // - If it's checked
        else {
          input.checked = false;
        }
      });
    });
  });
}

filterChecker();
