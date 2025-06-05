import React, { useState } from "react";
import axios from "axios";
import { API_URL } from "../../config/constants";
import "../ContactForm/ContactForm.module.css";

export default function ContactForm() {
  const [form, setForm] = useState({ 
    name: "", 
    email: "", 
    message: "" 
  });
  const [status, setStatus] = useState("");

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setStatus("Sending...");
    console.log('Submitting form data:', form);

    try {
      console.log('Sending request to:', `${API_URL}/contact`);
      const response = await axios.post(`${API_URL}/contact`, form, {
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        }
      });
      console.log('Success Response:', response.data);
      setStatus("Message sent!");
      setForm({ name: "", email: "", message: "" });
    } catch (error) {
      console.error('Error Response:', error.response?.data);
      console.error('Error Status:', error.response?.status);
      console.error('Error Headers:', error.response?.headers);
      if (error.response?.data?.errors) {
        setStatus("Error: " + Object.values(error.response.data.errors).flat().join(", "));
      } else {
        setStatus("An error occurred: " + (error.response?.data?.message || error.message));
      }
    }
  };

  return (
    <form onSubmit={handleSubmit}>
      <h2>Contact Us</h2>
      <input 
        name="name" 
        value={form.name} 
        onChange={handleChange} 
        placeholder="Your name" 
        required 
      />
      <input 
        name="email" 
        type="email"
        value={form.email} 
        onChange={handleChange} 
        placeholder="Your email" 
        required 
      />
      <textarea 
        name="message" 
        value={form.message} 
        onChange={handleChange} 
        placeholder="Your message" 
        required 
      />
      <button type="submit">Send</button>
      <p>{status}</p>
    </form>
  );
} 