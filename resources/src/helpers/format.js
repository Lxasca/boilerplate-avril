export function formatPrice(price) {
    return new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR', minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(price)
}

export function formatPercent(value) {
    return (value % 1 === 0 ? parseInt(value) : value) + ' %'
}

export function formatTruncate(text) {
    return text.length > 100 ? text.substring(0, 100) + ' ...' : text;
}