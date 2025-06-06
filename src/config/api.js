const API_CONFIG = {
    development: {
        baseURL: 'http://localhost:8006/api',
        timeout: 5000,
    },
    staging: {
        baseURL: 'https://staging-api.yourapp.com/api',
        timeout: 5000,
    },
    production: {
        baseURL: 'https://api.yourapp.com/api',
        timeout: 5000,
    }
};

// Get the current environment, default to development
const currentEnv = process.env.NODE_ENV || 'development';

// Export the configuration for the current environment
export const apiConfig = API_CONFIG[currentEnv];

// Export individual endpoints
export const endpoints = {
    contact: '/contact',
    login: '/login',
    signup: '/signup',
    events: '/events',
    // Add more endpoints as needed
}; 