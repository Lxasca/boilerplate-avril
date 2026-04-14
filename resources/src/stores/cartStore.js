import { defineStore } from 'pinia'
import axios from 'axios'

export const useCartStore = defineStore('cart', {
    state: () => ({
        cart: null,
        totalHT: 0,
        totalTTC: 0
    }),

    actions: {
        getCart() {
            axios.get('/cart').then((response) => {
                this.cart = response.data.cart

                this.totalHT = response.data.totalHT
                this.totalTTC = response.data.totalTTC
            })
        },
        add(productId) {
            axios.post('/cart/add', { product_id: productId, is_variant: isVariant })
            .then(() => {
                this.getCart()
            })
        },
        /**decrement(productId) {
            axios.delete('/cart/decrement', { params: { product_id: productId } }).then(() => {
                this.getCart()
            })
        },**/
        removeItem(productId) {
            axios.delete('/cart/removeItem', { params: { product_id: productId } }).then(() => {
                this.getCart()
            })
        },
        removeCart(cartId) {
            axios.delete('/cart/removeCart', { params: { cart_id: cartId } }).then(() => {
                this.cart = null;
            })
        }
    }
})