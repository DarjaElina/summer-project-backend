import api from './axios.js';

export const sendContactForm = async (formData) => {
    try {
        const response = await api.post('/contact', formData);
        return response.data;
    } catch (error) {
        throw error.response?.data || error.message;
    }
}; 