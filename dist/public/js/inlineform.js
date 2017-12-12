//@TODO object pattern

let httpRequest;
let savedForm;

/*
 * Helper for DOM manipulation
 */

function fadeIn(el) {
    el.style.opacity = 0;

    let last = +new Date();
    let tick = function() {
        el.style.opacity = +el.style.opacity + (new Date() - last) / 1000;
        last = +new Date();
        if (+el.style.opacity < 1) {
            (window.requestAnimationFrame && requestAnimationFrame(tick)) || setTimeout(tick, 1000);
        }
    };

    tick();
}

function fadeOut(el, callback) {
    el.style.opacity = 1;

    let last = +new Date();
    let tick = function() {
        el.style.opacity = +el.style.opacity - (new Date() - last) / 1000;
        last = +new Date();

        if (+el.style.opacity > 0) {
            (window.requestAnimationFrame && requestAnimationFrame(tick)) || setTimeout(tick, 1000);
        } else {
            callback();
        }
    };

    tick();
}

function insertForm(selector, text) {
    let jsForm = document.querySelector(selector);
    jsForm.style.opacity = 0;
    jsForm.innerHTML = text;
    fadeIn(jsForm);
}

function removeForm(selector) {
    let jsForm = document.querySelector(selector);
    fadeOut(jsForm, function() {
        jsForm.innerHTML = '';
    });
}

function insertNewContent(selector, html) {
    // Get list.
    let list = document.querySelector(selector);
    // Serialize and insert
    // https://developer.mozilla.org/en-US/docs/Web/API/Element/insertAdjacentHTML
    list.insertAdjacentHTML('beforeend', html);
}

function replaceFormFields(selector, html) {
    // Get form fields.
    let formFields = document.querySelector(selector);
    // Serialize and insert before
    formFields.insertAdjacentHTML('beforebegin', html);
    // Remove old form fields
    formFields.remove();
}

/*
 *
 * Using XMLHttpRequest
 *
 */

function makeRequest(url, method, callback, formData) {
    httpRequest = new XMLHttpRequest();

    if (!httpRequest) {
        console.log('Giving up :( Cannot create an XMLHTTP instance');
        return false;
    }
    httpRequest.onreadystatechange = callback;
    httpRequest.open(method, url);
    httpRequest.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    if (typeof(formData) !== undefined) {
        httpRequest.send(formData);
    } else {
        httpRequest.send(null);
    }
}


function submitForm(e) {
    e.preventDefault();
    let form = document.querySelector('.js-FormData');
    let formData = new FormData(form);
    makeRequest('/form', 'POST', handleFormSubmit, formData);
}

function captureSubmit() {
    let button = document.querySelector('.js-Button');
    button.addEventListener('click', submitForm, false);
}

function handleFormSubmit() {
    if (httpRequest.readyState === XMLHttpRequest.DONE) {
        if (httpRequest.status === 201) {
            // Created Item
            insertNewContent('.js-List', httpRequest.responseText);
            // Remove form
            removeForm('.js-Form');
        } else if (httpRequest.status === 422) {
            // We use this status (Unprocessable Entity) to
            // indicate missing form fields.
            replaceFormFields('.js-formFields', httpRequest.responseText);
        } else {
            alert('There was a problem with the request. Response-Code: ' + httpRequest.status);
        }
    }
}

function handleFormLoad() {
    if (httpRequest.readyState === XMLHttpRequest.DONE) {
        if (httpRequest.status === 200) {
            insertForm(".js-Form", httpRequest.responseText);
            captureSubmit();
        } else {
            let jsForm = document.querySelector(".js-Form");
            jsForm.innerText = 'There was a problem with the request: Error ' + httpRequest.status;
        }
    }
}

function loadForm(e) {
    e.preventDefault();
    makeRequest('/form', 'GET', handleFormLoad);
}

function initJS() {
    const link = document.querySelector('.js-Formlink');
    link.addEventListener('click', loadForm, false);
}

// Cutting the mustard
if ('querySelector' in document &&
    'FormData' in window &&
    'addEventListener' in window) {
    initJS();
}