// * Indicate message (success or failure) to user
// 1. Decorator
function decorateAllMessage() {
  var msgcons = document.querySelectorAll('*[name="message"]');
  msgcons.forEach((msgcon) => {
    var msg = msgcon.innerHTML; // Message
    if (msgcon.classList.contains("success")) {
      msgcon.innerHTML = msgSuccess(msg);
    } else if (msgcon.classList.contains("error")) {
      msgcon.innerHTML = msgError(msg);
    } else if (msgcon.classList.contains("warning")) {
      msgcon.innerHTML = msgWarning(msg);
    }
  });
}

// Decorate success message
function msgSuccess(msg) {
  return `<div class="mt-4 mb-4 border border-green-300 rounded-lg bg-green-400 bg-opacity-25 p-4 flex text-green-700 shadow-sm">
    <div>
      <svg class="w-6 mr-2" viewBox="0 0 52 52">
        <defs></defs>
        <path
          d="M18 32.465l-12-12L2.464 24 18 39.535 45.536 12 42 8.465z"
          fill="currentColor"
        ></path>
      </svg>
    </div>
    <div>
      <div class="text-sm font-semibold">Done!</div>
      <div class="text-sm font-light">${msg}</div>
    </div>
  </div>`;
}

// Decorate Error message
function msgError(msg) {
  return `<div class="mt-4 mb-4 border border-red-300 rounded-lg bg-red-400 bg-opacity-25 p-4 flex text-red-700 shadow-sm">
    <div>
      <svg class="w-6 mr-2" viewBox="0 0 512 512">
        <defs></defs>
        <path
          d="M256 56C145.72 56 56 145.72 56 256s89.72 200 200 200 200-89.72 200-200S366.28 56 256 56zm0 82a26 26 0 11-26 26 26 26 0 0126-26zm48 226h-88a16 16 0 010-32h28v-88h-16a16 16 0 010-32h32a16 16 0 0116 16v104h28a16 16 0 010 32z"
          fill="currentColor"
        ></path>
      </svg>
    </div>
    <div>
      <div class="text-sm font-semibold">Something went wrong...</div>
      <div class="text-sm font-light">${msg}</div>
    </div>
  </div>`;
}

// Decorate Warning message
function msgWarning(msg) {
  return `<div class="mt-4 mb-4 border border-yellow-300 rounded-lg bg-yellow-400 bg-opacity-25 p-4 flex text-yellow-700 shadow-sm">
    <div>
      <svg class="w-6 mr-2" viewBox="0 0 512 512">
        <defs></defs>
        <path
          d="M256 56C145.72 56 56 145.72 56 256s89.72 200 200 200 200-89.72 200-200S366.28 56 256 56zm0 82a26 26 0 11-26 26 26 26 0 0126-26zm48 226h-88a16 16 0 010-32h28v-88h-16a16 16 0 010-32h32a16 16 0 0116 16v104h28a16 16 0 010 32z"
          fill="currentColor"
        ></path>
      </svg>
    </div>
    <div>
      <div class="text-sm font-semibold">Warning!</div>
      <div class="text-sm font-light">${msg}</div>
    </div>
  </div>`;
}

// 2. Modal
// ==============================
// Modal
function openModal(mheader, mbody, mfooter) {
  // Prerequisite: "div" element pre-created
  var check_body_modal = document.getElementById("modal");
  // 1. Create a modal (id="modal")
  var modal = document.createElement("div");
  modal.setAttribute("id", "modal");
  // 2. Create a background hider + box (includes: header, content, footer) inside the modal
  var modalBgHider = document.createElement("div");
  modalBgHider.setAttribute("id", "modal-background-hider");
  modalBgHider.addEventListener("click", closeModal); // Close modal on click
  var modalBox = document.createElement("div");
  modalBox.setAttribute("class", "shadow-md");
  // Set id
  modalBox.setAttribute("id", "modal-box");
  mheader.setAttribute("id", "modal-header");
  mbody.setAttribute("id", "modal-body");
  mfooter.setAttribute("id", "modal-footer");
  // Append to modalBox
  modalBox.append(mheader, mbody, mfooter);
  // Append modalBox + background hider
  modal.append(modalBgHider, modalBox);

  // A. If modal is not existed
  if (!check_body_modal) {
    // 3. Set overflow of body to hidden
    var body = document.getElementsByTagName("body")[0];
    body.style.overflow = "hidden";
    // 4. Append to body
    body.append(modal);
  }
  // B. If modal is currently existed:
  // 3. Replace the current modal by the new one
  else {
    // Replace !!
    check_body_modal = modal;
  }
}

// Close modal function
function closeModal() {
  // 1. Body: Remove attribute style
  var body = document.getElementsByTagName("body")[0];
  body.removeAttribute("style");
  // 2. Modal: Remove modal
  var modal = document.getElementById("modal");
  if (modal) modal.parentElement.removeChild(modal); // Remove itself
}
