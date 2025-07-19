$(".product__color__select label, .shop__sidebar__size label, .product__details__option__jenwarna label").on('click', function () {
    $(".product__color__select label, .shop__sidebar__size label, .product__details__option__jenwarna label").removeClass('active');
    $(this).addClass('active');
});

/*-------------------
    Quantity change
--------------------- */
var proQty = $('.pro-qty');
proQty.prepend('<span class="fa fa-angle-up dec qtybtn"></span>');
proQty.append('<span class="fa fa-angle-down inc qtybtn"></span>');
proQty.on('click', '.qtybtn', function () {
    var $button = $(this);
    var oldValue = $button.parent().find('input').val();
    if ($button.hasClass('inc')) {
        var newVal = parseFloat(oldValue) + 1;
    } else {
        // Don't allow decrementing below zero
        if (oldValue > 0) {
            var newVal = parseFloat(oldValue) - 1;
        } else {
            newVal = 0;
        }
    }
    $button.parent().find('input').val(newVal);
});

// Add loading overlay to body
$('body').append('<div class="loading-overlay"></div>');

// Show overlay during AJAX request
$(document).ajaxStart(function() {
    $('.loading-overlay').fadeIn(200);
});

$(document).ajaxStop(function() {
    $('.loading-overlay').fadeOut(200);
});


// Helper functions for button states
function showLoadingState($button, $buttonText) {
    $button.prop('disabled', true)
            .addClass('btn-loading shimmer with-text');
    $buttonText.text('Memproses...');

    // Add pulse effect
    $button.addClass('pulse');
    setTimeout(() => $button.removeClass('pulse'), 600);
}

function showSuccessState($button, $buttonText) {
    $button.removeClass('btn-loading shimmer with-text')
            .addClass('btn-success');
    $buttonText.text('Berhasil!');
}

function showErrorState($button, $buttonText, originalText) {
    $button.prop('disabled', false)
            .removeClass('btn-loading shimmer with-text btn-success');
    $buttonText.text(originalText);
}

function showValidationError(message) {
    // Create custom alert with animation
    const alertHtml = `
        <div class="validation-alert">
            <div class="alert-content">
                <i class="fa fa-exclamation-triangle"></i>
                <span>${message}</span>
            </div>
        </div>
    `;

    if ($('.validation-alert').length === 0) {
        $('body').append(alertHtml);
        $('.validation-alert').fadeIn(300);

        setTimeout(() => {
            $('.validation-alert').fadeOut(300, function() {
                $(this).remove();
            });
        }, 3000);
    }
}

let colorIndex = 0;

// Event listener untuk color picker yang sudah ada
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('color-picker')) {
        const hexValue = e.target.value;
        const hexSpan = e.target.closest('.color-item').querySelector('.hex-value');
        hexSpan.textContent = hexValue;
        console.log('Kode Hex:', hexValue);
    }
});

// Fungsi untuk menambah warna baru
document.getElementById('addColor').addEventListener('click', function() {
    colorIndex++;
    const colorContainer = document.getElementById('colorContainer');

    const newColorItem = document.createElement('div');
    newColorItem.className = 'color-item';
    newColorItem.setAttribute('data-index', colorIndex);

    newColorItem.innerHTML = `
        <div class="form-group">
            <label for="colorPicker_${colorIndex}">Pilih Warna ${colorIndex + 1}:</label>
            <div class="input-group">
                <input type="color" name="warna_custom[]" id="colorPicker_${colorIndex}" class="form-control color-picker" value="#000000">
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger remove-color">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
            <small class="form-text text-muted">Kode Hex: <span class="hex-value">#000000</span></small>
        </div>
    `;

    colorContainer.appendChild(newColorItem);
    updateRemoveButtons();
});

// Event listener untuk tombol hapus
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-color') || e.target.parentElement.classList.contains('remove-color')) {
        const colorItem = e.target.closest('.color-item');
        if (colorItem) {
            colorItem.remove();
            updateLabels();
            updateRemoveButtons();
        }
    }
});

// Fungsi untuk update label nomor warna
function updateLabels() {
    const colorItems = document.querySelectorAll('.color-item');
    colorItems.forEach((item, index) => {
        const label = item.querySelector('label');
        const input = item.querySelector('.color-picker');
        label.textContent = `Pilih Warna ${index + 1}:`;
        label.setAttribute('for', `colorPicker_${index}`);
        input.setAttribute('id', `colorPicker_${index}`);
        item.setAttribute('data-index', index);
    });
}

// Fungsi untuk update status tombol hapus
function updateRemoveButtons() {
    const removeButtons = document.querySelectorAll('.remove-color');
    removeButtons.forEach(button => {
        button.disabled = removeButtons.length === 1;
    });
}

// Fungsi untuk mendapatkan semua nilai hex
function getAllHexValues() {
    const colorPickers = document.querySelectorAll('.color-picker');
    return Array.from(colorPickers).map(picker => picker.value);
}
