export const validateTypeText = {
    email: (value) => {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(value);
    },
    phone: (value) => {
        const regex = /^0[0-9]{9}$/;
        return regex.test(value);
    },
    password: (value) => {
        const regex = /^[\x20-\x7E]+$/;
        return regex.test(value);
    },
};
