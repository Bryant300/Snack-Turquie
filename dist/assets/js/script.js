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
const supplementSelect = document.querySelector('[data-option-supplement]');
const optionCancel = document.querySelector('[data-option-cancel]');
const customerName = document.querySelector('[data-customer-name]');
const customerPhone = document.querySelector('[data-customer-phone]');
const whatsappOrder = document.querySelector('[data-whatsapp-order]');

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
        supplement: options.supplement ?? '',
    });
}

function getCartTotal(cart) {
    return cart.reduce((total, item) => total + item.price * item.quantity, 0);
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
        const optionLines = [
            item.options?.sauce ? `Sauce : ${escapeHtml(item.options.sauce)}` : '',
            item.options?.drink ? `Boisson : ${escapeHtml(item.options.drink)}` : '',
            item.options?.supplement ? `Supplément : ${escapeHtml(item.options.supplement)} (+${formatPrice(item.options.supplementPrice ?? 0)})` : '',
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
    updateWhatsappLink();
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
}

function getSelectedSupplement() {
    if (!supplementSelect?.value) {
        return { name: '', price: 0 };
    }

    const selectedOption = supplementSelect.selectedOptions[0];
    const price = Number(selectedOption?.dataset.price ?? 0);

    return {
        name: supplementSelect.value,
        price: Number.isNaN(price) ? 0 : price,
    };
}

function getCartMessage(cart, name, phone) {
    const lines = [
        'Bonjour Snack Turquie, je souhaite passer commande.',
        '',
        `Nom : ${name}`,
        `Téléphone : ${phone}`,
        '',
        'Commande :',
    ];

    cart.forEach((item) => {
        lines.push(`- ${item.quantity}x ${item.name} - ${formatPrice(item.price * item.quantity)}`);

        if (item.options?.sauce) {
            lines.push(`  Sauce : ${item.options.sauce}`);
        }

        if (item.options?.drink) {
            lines.push(`  Boisson : ${item.options.drink}`);
        }

        if (item.options?.supplement) {
            lines.push(`  Supplément : ${item.options.supplement} (+${formatPrice(item.options.supplementPrice ?? 0)})`);
        }
    });

    lines.push('');
    lines.push(`Total : ${formatPrice(getCartTotal(cart))}`);

    return lines.join('\n');
}

function updateWhatsappLink() {
    if (!whatsappOrder) {
        return;
    }

    const cart = getCart();
    const name = customerName?.value.trim() ?? '';
    const phone = customerPhone?.value.trim() ?? '';
    const canOrder = cart.length > 0 && name && phone;

    whatsappOrder.classList.toggle('is-disabled', !canOrder);
    whatsappOrder.setAttribute('aria-disabled', String(!canOrder));

    if (!canOrder) {
        whatsappOrder.href = '#';
        return;
    }

    const message = encodeURIComponent(getCartMessage(cart, name, phone));
    whatsappOrder.href = `https://wa.me/3225239727?text=${message}`;
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
}

function removeCartItem(index) {
    const nextCart = getCart().filter((item, itemIndex) => itemIndex !== index);

    saveCart(nextCart);
    updateCartCount();
    renderCartPage();
}

function flashAdded(button, price) {
    button.textContent = 'Ajoute';

    setTimeout(() => {
        button.textContent = formatPrice(price);
    }, 900);
}

function openOptionModal(product) {
    if (!optionModal || !optionTitle || !sauceField || !drinkField || !supplementField || !sauceSelect || !drinkSelect || !supplementSelect) {
        addToCart(product.name, product.price);
        return;
    }

    optionTitle.textContent = product.name;
    sauceField.hidden = !product.optionsType.includes('sauce');
    drinkField.hidden = !product.optionsType.includes('drink');
    supplementField.hidden = false;
    sauceSelect.value = '';
    drinkSelect.value = '';
    supplementSelect.value = '';
    optionModal.hidden = false;
}

function closeOptionModal() {
    if (optionModal) {
        optionModal.hidden = true;
    }

    pendingProduct = null;
}

document.querySelectorAll('.menu-item__price').forEach((button) => {
    button.addEventListener('click', () => {
        const name = button.dataset.productName;
        const price = Number(button.dataset.productPrice);
        const optionsType = button.dataset.productOptions ?? 'none';

        if (!name || Number.isNaN(price)) {
            return;
        }

        if (optionsType !== 'none') {
            pendingProduct = { name, price, optionsType, button };
            openOptionModal(pendingProduct);
            return;
        }

        addToCart(name, price);
        flashAdded(button, price);
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

    const supplement = getSelectedSupplement();
    const finalPrice = pendingProduct.price + supplement.price;

    addToCart(pendingProduct.name, finalPrice, {
        sauce: needsSauce ? sauceSelect.value : '',
        drink: needsDrink ? drinkSelect.value : '',
        supplement: supplement.name,
        supplementPrice: supplement.price,
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
});

customerName?.addEventListener('input', updateWhatsappLink);
customerPhone?.addEventListener('input', updateWhatsappLink);

whatsappOrder?.addEventListener('click', (event) => {
    updateWhatsappLink();

    if (whatsappOrder.getAttribute('aria-disabled') === 'true') {
        event.preventDefault();

        if (!getCart().length) {
            cartEmpty?.focus();
            return;
        }

        if (!customerName?.value.trim()) {
            customerName?.focus();
            return;
        }

        customerPhone?.focus();
    }
});

updateCartCount();
renderCartPage();
