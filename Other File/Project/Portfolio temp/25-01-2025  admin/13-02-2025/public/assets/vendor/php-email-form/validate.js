/**
* PHP Email Form Validation - v3.9
* URL: https://bootstrapmade.com/php-email-form/
* Author: BootstrapMade.com
*/
// (function () {
//   "use strict";

//   let forms = document.querySelectorAll('.php-email-form');

//   forms.forEach( function(e) {
//     e.addEventListener('submit', function(event) {
//       event.preventDefault();

//       let thisForm = this;

//       let action = thisForm.getAttribute('action');
//       let recaptcha = thisForm.getAttribute('data-recaptcha-site-key');

//       if( ! action ) {
//         displayError(thisForm, 'The form action property is not set!');
//         return;
//       }
//       thisForm.querySelector('.loading').classList.add('d-block');
//       thisForm.querySelector('.error-message').classList.remove('d-block');
//       thisForm.querySelector('.sent-message').classList.remove('d-block');

//       let formData = new FormData( thisForm );

//       if ( recaptcha ) {
//         if(typeof grecaptcha !== "undefined" ) {
//           grecaptcha.ready(function() {
//             try {
//               grecaptcha.execute(recaptcha, {action: 'php_email_form_submit'})
//               .then(token => {
//                 formData.set('recaptcha-response', token);
//                 php_email_form_submit(thisForm, action, formData);
//               })
//             } catch(error) {
//               displayError(thisForm, error);
//             }
//           });
//         } else {
//           displayError(thisForm, 'The reCaptcha javascript API url is not loaded!')
//         }
//       } else {
//         php_email_form_submit(thisForm, action, formData);
//       }
//     });
//   });

//   function php_email_form_submit(thisForm, action, formData) {
//     fetch(action, {
//       method: 'POST',
//       body: formData,
//       headers: {'X-Requested-With': 'XMLHttpRequest'}
//     })
//     .then(response => {
//       if( response.ok ) {
//         return response.text();
//       } else {
//         throw new Error(`${response.status} ${response.statusText} ${response.url}`);
//       }
//     })
//     .then(data => {
//       thisForm.querySelector('.loading').classList.remove('d-block');
//       if (data.trim() == 'OK') {
//         thisForm.querySelector('.sent-message').classList.add('d-block');
//         thisForm.reset();
//       } else {
//         throw new Error(data ? data : 'Form submission failed and no error message returned from: ' + action);
//       }
//     })
//     .catch((error) => {
//       displayError(thisForm, error);
//     });
//   }

//   function displayError(thisForm, error) {
//     thisForm.querySelector('.loading').classList.remove('d-block');
//     thisForm.querySelector('.error-message').innerHTML = error;
//     thisForm.querySelector('.error-message').classList.add('d-block');
//   }

// })();

// converted into jquery above code

// (function () {
//     "use strict";

//     $('.php-email-form').on('submit', function (event) {
//         event.preventDefault();

//         let thisForm = $(this);
//         let action = thisForm.attr('action');
//         let recaptcha = thisForm.data('recaptcha-site-key');

//         if (!action) {
//             displayError(thisForm, 'The form action property is not set!');
//             return;
//         }

//         thisForm.find('.loading').addClass('d-block');
//         thisForm.find('.error-message').removeClass('d-block');
//         thisForm.find('.sent-message').removeClass('d-block');

//         let formData = new FormData(thisForm[0]);

//         if (recaptcha) {
//             if (typeof grecaptcha !== "undefined") {
//                 grecaptcha.ready(function () {
//                     try {
//                         grecaptcha.execute(recaptcha, { action: 'php_email_form_submit' })
//                             .then(function (token) {
//                                 formData.set('recaptcha-response', token);
//                                 php_email_form_submit(thisForm, action, formData);
//                             });
//                     } catch (error) {
//                         displayError(thisForm, error);
//                     }
//                 });
//             } else {
//                 displayError(thisForm, 'The reCaptcha javascript API url is not loaded!');
//             }
//         } else {
//             php_email_form_submit(thisForm, action, formData);
//         }
//     });

//     function php_email_form_submit(thisForm, action, formData) {
//         $.ajax({
//             url: action,
//             type: 'POST',
//             data: formData,
//             processData: false,
//             contentType: false,
//             beforeSend: function () {
//                 thisForm.find('.loading').addClass('d-block');
//             },
//             success: function (response) {
//                 thisForm.find('.loading').removeClass('d-block');
//                 if ($.trim(response) === 'OK') {
//                     thisForm.find('.sent-message').addClass('d-block');
//                     thisForm[0].reset();
//                 } else {
//                     displayError(thisForm, response || 'Form submission failed and no error message returned from: ' + action);
//                 }
//             },
//             error: function (xhr, status, error) {
//                 displayError(thisForm, `${xhr.status} ${xhr.statusText} ${xhr.responseText}`);
//             }
//         });
//     }

//     function displayError(thisForm, error) {
//         thisForm.find('.loading').removeClass('d-block');
//         thisForm.find('.error-message').html(error);
//         thisForm.find('.error-message').addClass('d-block');
//     }

// })();

