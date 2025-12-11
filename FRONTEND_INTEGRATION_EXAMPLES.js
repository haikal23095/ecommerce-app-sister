// ================================================
// CONTOH INTEGRASI API DENGAN FRONTEND
// E-Commerce REST API Integration Examples
// ================================================

// ================================================
// 1. SETUP AXIOS (React/Next.js/Vue)
// ================================================

// Install axios:
// npm install axios

// api.js - Axios configuration
import axios from 'axios';

const API_BASE_URL = 'http://localhost:8000/api';

const api = axios.create({
    baseURL: API_BASE_URL,
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
});

// Add token to requests automatically
api.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('authToken');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

export default api;


// ================================================
// 2. AUTHENTICATION SERVICE
// ================================================

// authService.js
import api from './api';

export const authService = {
    // Register
    async register(name, email, password, password_confirmation) {
        try {
            const response = await api.post('/register', {
                name,
                email,
                password,
                password_confirmation,
            });

            if (response.data.success) {
                // Save token to localStorage
                localStorage.setItem('authToken', response.data.data.token);
                localStorage.setItem('user', JSON.stringify(response.data.data.user));
            }

            return response.data;
        } catch (error) {
            throw error.response?.data || error;
        }
    },

    // Login
    async login(email, password) {
        try {
            const response = await api.post('/login', {
                email,
                password,
            });

            if (response.data.success) {
                localStorage.setItem('authToken', response.data.data.token);
                localStorage.setItem('user', JSON.stringify(response.data.data.user));
            }

            return response.data;
        } catch (error) {
            throw error.response?.data || error;
        }
    },

    // Logout
    async logout() {
        try {
            await api.post('/logout');
            localStorage.removeItem('authToken');
            localStorage.removeItem('user');
            return true;
        } catch (error) {
            throw error.response?.data || error;
        }
    },

    // Get current user
    async getCurrentUser() {
        try {
            const response = await api.get('/user');
            return response.data.data;
        } catch (error) {
            throw error.response?.data || error;
        }
    },

    // Check if user is authenticated
    isAuthenticated() {
        return !!localStorage.getItem('authToken');
    },

    // Get stored user
    getStoredUser() {
        const user = localStorage.getItem('user');
        return user ? JSON.parse(user) : null;
    },
};


// ================================================
// 3. PRODUCT SERVICE
// ================================================

// productService.js
import api from './api';

export const productService = {
    // Get all products
    async getAllProducts() {
        try {
            const response = await api.get('/produk');
            return response.data.data;
        } catch (error) {
            throw error.response?.data || error;
        }
    },

    // Get single product
    async getProduct(id) {
        try {
            const response = await api.get(`/produk/${id}`);
            return response.data.data;
        } catch (error) {
            throw error.response?.data || error;
        }
    },

    // Create product (Admin only)
    async createProduct(productData) {
        try {
            const response = await api.post('/produk', productData);
            return response.data.data;
        } catch (error) {
            throw error.response?.data || error;
        }
    },

    // Update product (Admin only)
    async updateProduct(id, productData) {
        try {
            const response = await api.put(`/produk/${id}`, productData);
            return response.data.data;
        } catch (error) {
            throw error.response?.data || error;
        }
    },

    // Delete product (Admin only)
    async deleteProduct(id) {
        try {
            const response = await api.delete(`/produk/${id}`);
            return response.data;
        } catch (error) {
            throw error.response?.data || error;
        }
    },
};


// ================================================
// 4. TRANSACTION SERVICE
// ================================================

// transactionService.js
import api from './api';

export const transactionService = {
    // Get all transactions
    async getAllTransactions(filters = {}) {
        try {
            const params = new URLSearchParams(filters).toString();
            const response = await api.get(`/transaksi${params ? '?' + params : ''}`);
            return response.data.data;
        } catch (error) {
            throw error.response?.data || error;
        }
    },

    // Get user's transactions
    async getUserTransactions(userId) {
        try {
            const response = await api.get(`/transaksi?user_id=${userId}`);
            return response.data.data;
        } catch (error) {
            throw error.response?.data || error;
        }
    },

    // Get single transaction
    async getTransaction(id) {
        try {
            const response = await api.get(`/transaksi/${id}`);
            return response.data.data;
        } catch (error) {
            throw error.response?.data || error;
        }
    },

    // Create transaction
    async createTransaction(transactionData) {
        try {
            const response = await api.post('/transaksi', transactionData);
            return response.data.data;
        } catch (error) {
            throw error.response?.data || error;
        }
    },

    // Update transaction status
    async updateTransaction(id, updateData) {
        try {
            const response = await api.put(`/transaksi/${id}`, updateData);
            return response.data.data;
        } catch (error) {
            throw error.response?.data || error;
        }
    },

    // Delete transaction
    async deleteTransaction(id) {
        try {
            const response = await api.delete(`/transaksi/${id}`);
            return response.data;
        } catch (error) {
            throw error.response?.data || error;
        }
    },
};


// ================================================
// 5. PAYMENT SERVICE
// ================================================

// paymentService.js
import api from './api';

export const paymentService = {
    // Get all payments
    async getAllPayments(filters = {}) {
        try {
            const params = new URLSearchParams(filters).toString();
            const response = await api.get(`/pembayaran${params ? '?' + params : ''}`);
            return response.data.data;
        } catch (error) {
            throw error.response?.data || error;
        }
    },

    // Get payment by transaction
    async getPaymentByTransaction(transactionId) {
        try {
            const response = await api.get(`/pembayaran?transaksi_id=${transactionId}`);
            return response.data.data;
        } catch (error) {
            throw error.response?.data || error;
        }
    },

    // Create payment
    async createPayment(paymentData) {
        try {
            const response = await api.post('/pembayaran', paymentData);
            return response.data.data;
        } catch (error) {
            throw error.response?.data || error;
        }
    },

    // Update payment status
    async updatePaymentStatus(id, status) {
        try {
            const response = await api.put(`/pembayaran/${id}`, {
                status_pembayaran: status,
            });
            return response.data.data;
        } catch (error) {
            throw error.response?.data || error;
        }
    },
};


// ================================================
// 6. REACT COMPONENT EXAMPLES
// ================================================

// Example 1: Login Component
import React, { useState } from 'react';
import { authService } from './services/authService';

function LoginPage() {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [error, setError] = useState('');
    const [loading, setLoading] = useState(false);

    const handleLogin = async (e) => {
        e.preventDefault();
        setLoading(true);
        setError('');

        try {
            const response = await authService.login(email, password);
            console.log('Login success:', response);
            // Redirect to dashboard or home
            window.location.href = '/dashboard';
        } catch (err) {
            setError(err.message || 'Login gagal');
        } finally {
            setLoading(false);
        }
    };

    return (
        <div>
            <h2>Login</h2>
            {error && <div className="error">{error}</div>}
            <form onSubmit={handleLogin}>
                <input
                    type="email"
                    placeholder="Email"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    required
                />
                <input
                    type="password"
                    placeholder="Password"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    required
                />
                <button type="submit" disabled={loading}>
                    {loading ? 'Loading...' : 'Login'}
                </button>
            </form>
        </div>
    );
}


// Example 2: Product List Component
import React, { useState, useEffect } from 'react';
import { productService } from './services/productService';

function ProductList() {
    const [products, setProducts] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState('');

    useEffect(() => {
        loadProducts();
    }, []);

    const loadProducts = async () => {
        try {
            const data = await productService.getAllProducts();
            setProducts(data);
        } catch (err) {
            setError(err.message || 'Failed to load products');
        } finally {
            setLoading(false);
        }
    };

    if (loading) return <div>Loading...</div>;
    if (error) return <div>Error: {error}</div>;

    return (
        <div className="product-grid">
            {products.map((product) => (
                <div key={product.id} className="product-card">
                    <img src={product.gambar} alt={product.nama_produk} />
                    <h3>{product.nama_produk}</h3>
                    <p>Rp {parseFloat(product.harga).toLocaleString('id-ID')}</p>
                    <p>Stok: {product.stok}</p>
                </div>
            ))}
        </div>
    );
}


// Example 3: Checkout Component
import React, { useState } from 'react';
import { transactionService } from './services/transactionService';
import { authService } from './services/authService';

function CheckoutPage({ cartItems, totalPrice }) {
    const [address, setAddress] = useState('');
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState('');

    const handleCheckout = async (e) => {
        e.preventDefault();
        setLoading(true);
        setError('');

        try {
            const user = authService.getStoredUser();

            const transactionData = {
                user_id: user.id,
                total_harga: totalPrice,
                alamat_pengiriman: address,
                status: 'pending',
                details: cartItems.map(item => ({
                    produk_id: item.id,
                    jumlah: item.quantity,
                    harga_satuan: item.harga,
                    subtotal: item.harga * item.quantity,
                })),
            };

            const response = await transactionService.createTransaction(transactionData);
            console.log('Transaction created:', response);

            // Redirect to payment page
            window.location.href = `/pembayaran/${response.id}`;
        } catch (err) {
            setError(err.message || 'Checkout gagal');
        } finally {
            setLoading(false);
        }
    };

    return (
        <div>
            <h2>Checkout</h2>
            {error && <div className="error">{error}</div>}
            <form onSubmit={handleCheckout}>
                <div>
                    <h3>Order Summary</h3>
                    {cartItems.map((item) => (
                        <div key={item.id}>
                            {item.nama_produk} x {item.quantity} = Rp {(item.harga * item.quantity).toLocaleString('id-ID')}
                        </div>
                    ))}
                    <div><strong>Total: Rp {totalPrice.toLocaleString('id-ID')}</strong></div>
                </div>

                <textarea
                    placeholder="Alamat Pengiriman"
                    value={address}
                    onChange={(e) => setAddress(e.target.value)}
                    required
                />

                <button type="submit" disabled={loading}>
                    {loading ? 'Processing...' : 'Checkout'}
                </button>
            </form>
        </div>
    );
}


// ================================================
// 7. VUE.JS COMPOSABLE EXAMPLE
// ================================================

// useAuth.js (Vue 3 Composition API)
import { ref, computed } from 'vue';
import { authService } from './services/authService';

export function useAuth() {
    const user = ref(authService.getStoredUser());
    const isAuthenticated = computed(() => authService.isAuthenticated());
    const loading = ref(false);
    const error = ref(null);

    const login = async (email, password) => {
        loading.value = true;
        error.value = null;

        try {
            const response = await authService.login(email, password);
            user.value = response.data.user;
            return response;
        } catch (err) {
            error.value = err.message;
            throw err;
        } finally {
            loading.value = false;
        }
    };

    const logout = async () => {
        loading.value = true;

        try {
            await authService.logout();
            user.value = null;
        } catch (err) {
            error.value = err.message;
            throw err;
        } finally {
            loading.value = false;
        }
    };

    const register = async (name, email, password, password_confirmation) => {
        loading.value = true;
        error.value = null;

        try {
            const response = await authService.register(name, email, password, password_confirmation);
            user.value = response.data.user;
            return response;
        } catch (err) {
            error.value = err.message;
            throw err;
        } finally {
            loading.value = false;
        }
    };

    return {
        user,
        isAuthenticated,
        loading,
        error,
        login,
        logout,
        register,
    };
}


// ================================================
// 8. ERROR HANDLING UTILITIES
// ================================================

// errorHandler.js
export const handleApiError = (error) => {
    if (error.response) {
        // Server responded with error
        if (error.response.status === 401) {
            // Unauthorized - redirect to login
            localStorage.removeItem('authToken');
            localStorage.removeItem('user');
            window.location.href = '/login';
        } else if (error.response.status === 422) {
            // Validation error
            return error.response.data.errors;
        } else if (error.response.status === 404) {
            return 'Data tidak ditemukan';
        } else if (error.response.status === 500) {
            return 'Server error, silakan coba lagi';
        }
        return error.response.data.message || 'Terjadi kesalahan';
    } else if (error.request) {
        // Request made but no response
        return 'Tidak dapat terhubung ke server';
    } else {
        // Other errors
        return error.message || 'Terjadi kesalahan';
    }
};


// ================================================
// NOTES:
// ================================================
// 1. Jangan lupa install axios: npm install axios
// 2. Sesuaikan API_BASE_URL dengan environment (development/production)
// 3. Gunakan environment variables untuk API URL (.env file)
// 4. Implementasi refresh token jika diperlukan
// 5. Tambahkan loading states untuk better UX
// 6. Handle errors dengan baik untuk user feedback
