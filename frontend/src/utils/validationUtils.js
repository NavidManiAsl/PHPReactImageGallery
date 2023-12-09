export const validateUsername = (username) => {
    username = username?.trim();
    return { status: username.length > 0 && username.length > 3, message: 'username must be at least 3 characters' }
};


export const validatePassword = (password, passwordConfirmation = null) => {
    if (!password || password.length < 8) {
        return { belongsTo: 'password', status: false, message: 'Password must be at least 8 characters' };
    }
    if (passwordConfirmation) {
        if (password !== passwordConfirmation) {
            return { belongsTo: 'passwordConfirm', status: false, message: 'Password and confirmation are not match' };
        }
    }
    return true
};
export const validateEmail = (email) => {
    email = email?.trim();
    let regex = /^[a-z0-9]?.+@[a-z]+\.[a-z0-9]{2,3}$/;
    return { status: regex.test(email), message: 'invalid email' };
};

export const validateRegisterData = (username, email, password, passwordConfirm) => {
    const error = { username: '', email: '', password: '', passwordConfirm: '' }
    const { status: validUsername, message: usernameError } = validateUsername(username);
if(!validUsername) error.username = usernameError;

    const { status: validEmail, message: emailError } = validateEmail(email);

   if(!validEmail) error.email=emailError;

    const { belongsTo: belongsTo, status: validPassword, message: passwordError } = validatePassword(password, passwordConfirm);

    if(!validPassword && belongsTo=='password') {
        error.password = passwordError;
    }
    if(!validPassword && belongsTo=='passwordConfirm') {
        error.passwordConfirm = passwordError;
    }
  
    
    if(!error.username &&!error.password &&!error.passwordConfirm &&!error.email) return false;
        
      
        return error;
};