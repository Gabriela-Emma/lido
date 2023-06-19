export function currency(value, currency: string = 'USD', locale: string = 'en-US',  maximumFractionDigits = 0) {
    if (typeof value !== "number") {
        return value;
    }
    console.log({value, locale, currency, maximumFractionDigits});
    switch (currency) {
        case 'ADA':
            return `${value} ₳`;
        default:
            const formatter = new Intl.NumberFormat(locale, {
                style: 'currency',
                currency,
                maximumFractionDigits
            });
            return formatter.format(value);
    }
}
