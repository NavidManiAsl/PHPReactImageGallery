export const validateUsername = (username) => {
    username = username?.trim();
    return { status: username && username.length > 3, message:'username must be at least 3 characters' }
};


export const validatePassword = (password, passwordConfirmation = null) => {
    if (!password || password.length < 8) {
        return { status: false, message: 'Password must be at least 8 characters' };
    }
    if (passwordConfirmation) {
        if (password !== passwordConfirmation) {
            return { status: false, message: 'Password and confirmation are not match' };
        }
    }
    return true
};
export const validateEmail = (email) => {
    email = email?.trim();
    let regex = /^[a-z0-9]+@[a-z]+\.[a-z0-9]{2,3}$/;
    return {status:regex.test(email), message:'invalid email'};
};