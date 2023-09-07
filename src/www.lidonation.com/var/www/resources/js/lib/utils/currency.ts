import { shortNumber } from "./shortNumber";

export function currency(value, currency: string = 'USD', locale: string = 'en-US',  maximumFractionDigits = 0) {
    if (typeof value !== "number") {
        return value;
    }
    switch (currency) {
        case 'ADA':
            return shortNumber(value, maximumFractionDigits, locale) + ' ₳';
        default:
            const formatter = new Intl.NumberFormat(locale, {
                style: 'currency',
                notation: 'compact',
                currency,
                maximumFractionDigits
            });
            return formatter.format(value);
    }
}
