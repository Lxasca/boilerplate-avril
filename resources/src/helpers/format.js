export function formatPrice(price) {
    return new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(price)
}

export function formatTruncate(text) {
    return text.length > 100 ? text.substring(0, 100) + ' ...' : text;
}