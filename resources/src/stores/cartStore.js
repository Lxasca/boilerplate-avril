import { defineStore } from 'pinia'
import axios from 'axios'

export const useCartStore = defineStore('cart', {
    state: () => ({
        cart: null
    }),

    actions: {
        getCart() {
            axios.get('/cart').then((response) => {
                this.cart = response.data
            })
        },
        add(productId) {
            axios.post('/cart/add', { product_id: productId }).then(() => {
                this.getCart()
            })
        },
        decrement(productId) {
            axios.delete('/cart/decrement', { params: { product_id: productId } }).then(() => {
                this.getCart()
            })
        }
    }
})