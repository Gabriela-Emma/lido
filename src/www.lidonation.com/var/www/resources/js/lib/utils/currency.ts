export function currency(value, locale: string = 'en-US') {
    if (typeof value !== "number") {
        return value;
    }
    const formatter = new Intl.NumberFormat(locale, {
        style: 'currency',
        currency: 'USD',
        maximumFractionDigits: 0
    });
    return formatter.format(value);
}
