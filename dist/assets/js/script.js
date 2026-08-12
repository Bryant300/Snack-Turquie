const menuFilterButtons = document.querySelectorAll('[data-menu-filter]');
const menuItems = document.querySelectorAll('[data-menu-item]');
const menuSections = document.querySelectorAll('[data-menu-section]');
const menuEmpty = document.querySelector('[data-menu-empty]');

let activeMenuFilter = 'all';

function updateMenuVisibility() {
    let visibleCount = 0;

    menuItems.forEach((item) => {
        const group = item.dataset.menuGroup;
        const isVisible = activeMenuFilter === 'all' || group === activeMenuFilter;

        item.hidden = !isVisible;

        if (isVisible) {
            visibleCount += 1;
        }
    });

    document.querySelectorAll('[data-menu-subsection]').forEach((subsection) => {
        const hasVisibleItem = [...subsection.querySelectorAll('[data-menu-item]')]
            .some((item) => !item.hidden);

        subsection.hidden = !hasVisibleItem;
    });

    menuSections.forEach((section) => {
        const hasVisibleItem = [...section.querySelectorAll('[data-menu-item]')]
            .some((item) => !item.hidden);

        section.hidden = !hasVisibleItem;
    });

    if (menuEmpty) {
        menuEmpty.hidden = visibleCount > 0;
    }
}

menuFilterButtons.forEach((button) => {
    button.addEventListener('click', () => {
        activeMenuFilter = button.dataset.menuFilter ?? 'all';

        menuFilterButtons.forEach((filterButton) => {
            filterButton.classList.toggle('is-active', filterButton === button);
        });

        updateMenuVisibility();
    });
});

const CART_STORAGE_KEY = 'snack-turquie-cart';
const CHECKOUT_DETAILS_KEY = 'snack-turquie-checkout';

const cartCount = document.querySelector('.cart-button__count');
const cartList = document.querySelector('[data-cart-list]');
const cartEmpty = document.querySelector('[data-cart-empty]');
const cartSummary = document.querySelector('[data-cart-summary]');
const cartTotal = document.querySelector('[data-cart-total]');
const cartClear = document.querySelector('[data-cart-clear]');

const optionModal = document.querySelector('[data-option-modal]');
const optionForm = document.querySelector('[data-option-form]');
const optionTitle = document.querySelector('[data-option-title]');
const sauceField = document.querySelector('[data-sauce-field]');
const drinkField = document.querySelector('[data-drink-field]');
const supplementField = document.querySelector('[data-supplement-field]');
const sauceSelect = document.querySelector('[data-option-sauce]');
const drinkSelect = document.querySelector('[data-option-drink]');
const supplementInputs = document.querySelectorAll('[data-option-supplement]');
const optionCancel = document.querySelector('[data-option-cancel]');
const customerName = document.querySelector('[data-customer-name]');
const customerPhone = document.querySelector('[data-customer-phone]');
const orderType = document.querySelector('[data-order-type]');
const orderTime = document.querySelector('[data-order-time]');
const orderNote = document.querySelector('[data-order-note]');
const checkoutLink = document.querySelector('[data-checkout-link]');
const checkoutEmpty = document.querySelector('[data-checkout-empty]');
const checkoutCustomer = document.querySelector('[data-checkout-customer]');
const checkoutOrder = document.querySelector('[data-checkout-order]');
const checkoutPayment = document.querySelector('[data-checkout-payment]');
const checkoutList = document.querySelector('[data-checkout-list]');
const checkoutTotal = document.querySelector('[data-checkout-total]');
const checkoutName = document.querySelector('[data-checkout-name]');
const checkoutPhone = document.querySelector('[data-checkout-phone]');
const checkoutTime = document.querySelector('[data-checkout-time]');
const checkoutNote = document.querySelector('[data-checkout-note]');

let pendingProduct = null;

function getCart() {
    try {
        return JSON.parse(localStorage.getItem(CART_STORAGE_KEY)) ?? [];
    } catch {
        return [];
    }
}

function saveCart(cart) {
    localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(cart));
}

function formatPrice(price) {
    return new Intl.NumberFormat('fr-BE', {
        style: 'currency',
        currency: 'EUR',
    }).format(price);
}

function escapeHtml(value) {
    const div = document.createElement('div');
    div.textContent = value;

    return div.innerHTML;
}

function getOptionSignature(options = {}) {
    return JSON.stringify({
        sauce: options.sauce ?? '',
        drink: options.drink ?? '',
        supplements: getCartItemSupplements(options).map((supplement) => supplement.name),
    });
}

function getCartTotal(cart) {
    return cart.reduce((total, item) => total + item.price * item.quantity, 0);
}

function getCartItemSupplements(options = {}) {
    if (Array.isArray(options.supplements)) {
        return options.supplements;
    }

    if (options.supplement) {
        return [{
            name: options.supplement,
            price: options.supplementPrice ?? 0,
        }];
    }

    return [];
}

function updateCartCount() {
    const totalQuantity = getCart().reduce((total, item) => total + item.quantity, 0);

    if (cartCount) {
        cartCount.textContent = String(totalQuantity);
    }
}

function renderCartPage() {
    if (!cartList || !cartEmpty || !cartSummary || !cartTotal) {
        return;
    }

    const cart = getCart();
    const hasItems = cart.length > 0;

    cartEmpty.hidden = hasItems;
    cartList.hidden = !hasItems;
    cartSummary.hidden = !hasItems;

    cartList.innerHTML = '';

    cart.forEach((item, index) => {
        const supplements = getCartItemSupplements(item.options);
        const optionLines = [
            item.options?.sauce ? `Sauce : ${escapeHtml(item.options.sauce)}` : '',
            item.options?.drink ? `Boisson : ${escapeHtml(item.options.drink)}` : '',
            supplements.length ? `Suppléments : ${supplements.map((supplement) => `${escapeHtml(supplement.name)} (+${formatPrice(supplement.price)})`).join(', ')}` : '',
        ].filter(Boolean);

        const row = document.createElement('article');
        row.className = 'cart-item';
        row.innerHTML = `
            <div>
                <h2>${escapeHtml(item.name)}</h2>
                <p>${formatPrice(item.price)} x ${item.quantity}</p>
                ${optionLines.length ? `<ul class="cart-item__options">${optionLines.map((line) => `<li>${line}</li>`).join('')}</ul>` : ''}
            </div>

            <div class="cart-item__controls">
                <button type="button" data-cart-decrease="${index}" aria-label="Retirer un produit">-</button>
                <span>${item.quantity}</span>
                <button type="button" data-cart-increase="${index}" aria-label="Ajouter un produit">+</button>
                <button type="button" data-cart-remove="${index}">Supprimer</button>
            </div>
        `;

        cartList.append(row);
    });

    cartTotal.textContent = formatPrice(getCartTotal(cart));
    updateCheckoutLink();
}

function addToCart(name, price, options = {}) {
    const cart = getCart();
    const optionSignature = getOptionSignature(options);
    const existingItem = cart.find((item) => {
        return item.name === name && getOptionSignature(item.options) === optionSignature;
    });

    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({ name, price, options, quantity: 1 });
    }

    saveCart(cart);
    updateCartCount();
    renderCartPage();
    renderCheckoutPage();
}

function getSelectedSupplements() {
    return [...supplementInputs]
        .filter((input) => input.checked)
        .map((input) => {
            const price = Number(input.dataset.price ?? 0);

            return {
                name: input.value,
                price: Number.isNaN(price) ? 0 : price,
            };
        });
}

function getCheckoutDetails() {
    try {
        return JSON.parse(sessionStorage.getItem(CHECKOUT_DETAILS_KEY)) ?? {};
    } catch {
        return {};
    }
}

function saveCheckoutDetails() {
    const details = {
        name: customerName?.value.trim() ?? '',
        phone: customerPhone?.value.trim() ?? '',
        type: 'Retrait sur place',
        time: orderTime?.value.trim() ?? '',
        note: orderNote?.value.trim() ?? '',
    };

    sessionStorage.setItem(CHECKOUT_DETAILS_KEY, JSON.stringify(details));

    return details;
}

function updateCheckoutLink() {
    if (!checkoutLink) {
        return;
    }

    const cart = getCart();
    const name = customerName?.value.trim() ?? '';
    const phone = customerPhone?.value.trim() ?? '';
    const canCheckout = cart.length > 0 && name && phone;

    checkoutLink.classList.toggle('is-disabled', !canCheckout);
    checkoutLink.setAttribute('aria-disabled', String(!canCheckout));
}

function renderCheckoutPage() {
    if (!checkoutList || !checkoutTotal || !checkoutEmpty || !checkoutCustomer || !checkoutOrder || !checkoutPayment) {
        return;
    }

    const cart = getCart();
    const details = getCheckoutDetails();
    const hasCart = cart.length > 0;

    checkoutEmpty.hidden = hasCart;
    checkoutCustomer.hidden = !hasCart;
    checkoutOrder.hidden = !hasCart;
    checkoutPayment.hidden = !hasCart;

    if (checkoutName) checkoutName.textContent = details.name || '-';
    if (checkoutPhone) checkoutPhone.textContent = details.phone || '-';
    if (checkoutTime) checkoutTime.textContent = details.time || 'Dès que possible';
    if (checkoutNote) checkoutNote.textContent = details.note || 'Aucune remarque';

    checkoutList.innerHTML = '';

    cart.forEach((item) => {
        const supplements = getCartItemSupplements(item.options);
        const optionLines = [
            item.options?.sauce ? `Sauce : ${escapeHtml(item.options.sauce)}` : '',
            item.options?.drink ? `Boisson : ${escapeHtml(item.options.drink)}` : '',
            supplements.length ? `Suppléments : ${supplements.map((supplement) => `${escapeHtml(supplement.name)} (+${formatPrice(supplement.price)})`).join(', ')}` : '',
        ].filter(Boolean);

        const row = document.createElement('article');
        row.className = 'checkout-item';
        row.innerHTML = `
            <div>
                <h3>${escapeHtml(item.name)}</h3>
                ${optionLines.length ? `<ul>${optionLines.map((line) => `<li>${line}</li>`).join('')}</ul>` : ''}
            </div>
            <strong>${item.quantity} x ${formatPrice(item.price)}</strong>
        `;

        checkoutList.append(row);
    });

    checkoutTotal.textContent = formatPrice(getCartTotal(cart));
}

function updateCartItem(index, change) {
    const cart = getCart();
    const item = cart[index];

    if (!item) {
        return;
    }

    item.quantity += change;

    const nextCart = cart.filter((cartItem) => cartItem.quantity > 0);
    saveCart(nextCart);
    updateCartCount();
    renderCartPage();
    renderCheckoutPage();
}

function removeCartItem(index) {
    const nextCart = getCart().filter((item, itemIndex) => itemIndex !== index);

    saveCart(nextCart);
    updateCartCount();
    renderCartPage();
    renderCheckoutPage();
}

function flashAdded(button, price) {
    button.textContent = 'Ajoute';

    setTimeout(() => {
        button.textContent = formatPrice(price);
    }, 900);
}

function openOptionModal(product) {
    if (!optionModal || !optionTitle || !sauceField || !drinkField || !supplementField || !sauceSelect || !drinkSelect) {
        addToCart(product.name, product.price);
        return;
    }

    optionTitle.textContent = product.name;
    sauceField.hidden = !product.optionsType.includes('sauce');
    drinkField.hidden = !product.optionsType.includes('drink');
    supplementField.hidden = false;
    sauceSelect.value = '';
    drinkSelect.value = '';
    supplementInputs.forEach((input) => {
        input.checked = false;
    });
    optionModal.hidden = false;
}

function closeOptionModal() {
    if (optionModal) {
        optionModal.hidden = true;
    }

    pendingProduct = null;
}

function selectProduct(card) {
    const button = card.querySelector('.menu-item__price');
    const name = card.dataset.productName;
    const price = Number(card.dataset.productPrice);
    const optionsType = card.dataset.productOptions ?? 'none';

    if (!button || !name || Number.isNaN(price)) {
        return;
    }

    if (optionsType !== 'none') {
        pendingProduct = { name, price, optionsType, button };
        openOptionModal(pendingProduct);
        return;
    }

    addToCart(name, price);
    flashAdded(button, price);
}

document.querySelectorAll('[data-menu-item]').forEach((card) => {
    card.addEventListener('click', () => {
        selectProduct(card);
    });
});

optionCancel?.addEventListener('click', closeOptionModal);

optionModal?.addEventListener('click', (event) => {
    if (event.target === optionModal) {
        closeOptionModal();
    }
});

optionForm?.addEventListener('submit', (event) => {
    event.preventDefault();

    if (!pendingProduct || !sauceSelect || !drinkSelect) {
        return;
    }

    const needsSauce = pendingProduct.optionsType.includes('sauce');
    const needsDrink = pendingProduct.optionsType.includes('drink');

    if (needsSauce && !sauceSelect.value) {
        sauceSelect.focus();
        return;
    }

    if (needsDrink && !drinkSelect.value) {
        drinkSelect.focus();
        return;
    }

    const supplements = getSelectedSupplements();
    const supplementTotal = supplements.reduce((total, supplement) => total + supplement.price, 0);
    const finalPrice = pendingProduct.price + supplementTotal;

    addToCart(pendingProduct.name, finalPrice, {
        sauce: needsSauce ? sauceSelect.value : '',
        drink: needsDrink ? drinkSelect.value : '',
        supplements,
    });

    flashAdded(pendingProduct.button, pendingProduct.price);
    closeOptionModal();
});

cartList?.addEventListener('click', (event) => {
    const target = event.target;

    if (!(target instanceof HTMLButtonElement)) {
        return;
    }

    if (target.dataset.cartIncrease) {
        updateCartItem(Number(target.dataset.cartIncrease), 1);
    }

    if (target.dataset.cartDecrease) {
        updateCartItem(Number(target.dataset.cartDecrease), -1);
    }

    if (target.dataset.cartRemove) {
        removeCartItem(Number(target.dataset.cartRemove));
    }
});

cartClear?.addEventListener('click', () => {
    saveCart([]);
    updateCartCount();
    renderCartPage();
    renderCheckoutPage();
});

customerName?.addEventListener('input', updateCheckoutLink);
customerPhone?.addEventListener('input', updateCheckoutLink);
orderType?.addEventListener('change', updateCheckoutLink);
orderTime?.addEventListener('input', updateCheckoutLink);
orderNote?.addEventListener('input', updateCheckoutLink);

checkoutLink?.addEventListener('click', (event) => {
    updateCheckoutLink();

    if (checkoutLink.getAttribute('aria-disabled') === 'true') {
        event.preventDefault();

        if (!getCart().length) {
            cartEmpty?.focus();
            return;
        }

        if (!customerName?.value.trim()) {
            customerName?.focus();
            return;
        }

        if (!customerPhone?.value.trim()) {
            customerPhone?.focus();
            return;
        }
    }

    saveCheckoutDetails();
});

updateCartCount();
renderCartPage();
    renderCheckoutPage();

if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/service-worker.js').catch(() => {});
    });
}
