function openLogin() {
  $("#loginModal").modal("show");
}

function openRegister() {
  $("#registerModal").modal("show");
}

// document.addEventListener("DOMContentLoaded", function () {
//   // Handle registration form submission
//   document
//     .getElementById("registerForm")
//     .addEventListener("submit", function (e) {
//       e.preventDefault();
//       displayTable(getFormData(this));
//     });

//   // Handle login form submission
//   document.getElementById("loginForm").addEventListener("submit", function (e) {
//     e.preventDefault();
//     displayTable(getFormData(this));
//   });

//   function getFormData(form) {
//     const formData = new FormData(form);
//     const data = {};
//     formData.forEach((value, key) => {
//       data[key] = value;
//     });
//     return data;
//   }

//   function displayTable(data) {
//     const tableBody = Object.keys(data)
//       .map((key) => `<tr><td>${key}</td><td>${data[key]}</td></tr>`)
//       .join("");

//     const tableHTML = `
//                 <table border="1">
//                     <thead>
//                         <tr>
//                             <th>Field</th>
//                             <th>Value</th>
//                         </tr>
//                     </thead>
//                     <tbody>
//                         ${tableBody}
//                     </tbody>
//                 </table>
//             `;

//     const newTab = window.open();
//     newTab.document.write(`
//                 <!DOCTYPE html>
//                 <html lang="en">
//                 <head>
//                     <meta charset="UTF-8">
//                     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
//                     <title>Form Data Table</title>
//                 </head>
//                 <body>
//                     <h2>Form Data Table</h2>
//                     ${tableHTML}
//                 </body>
//                 </html>
//             `);
//   }
// });

// const priceRange = document.getElementById("priceRange");
// const minPriceDisplay = document.getElementById("minPrice");
// const maxPriceDisplay = document.getElementById("maxPrice");
 
// priceRange.addEventListener("input", function() {
//     const minPrice = "$" + this.value;
//     const maxPrice = "$" + this.max;
 
//     minPriceDisplay.textContent = minPrice;
//     maxPriceDisplay.textContent = maxPrice;
// });



