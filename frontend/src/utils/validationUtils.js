export const validateUsername = (username) => {
    username = username.trim();
    if (!username || username.length < 3) {
        return false;
    }
    return true;
};


export const validatePassword = (password, passwordConfirmation = null) => {
    if(!password || password.length < 8){
        return false;
    }
    if (passwordConfirmation) {
        if(password !== passwordConfirmation){
            return false
        }
    }
    return true
};
export const validateEmail = (email) => {
    email = email.trim();
    let regex = /^[a-z0-9]+@[a-z]+\.[a-z]{2,3}$/;
    return regex.test(email);
};