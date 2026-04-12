import { defineStore } from 'pinia'
import axios from 'axios'

export const useCartStore = defineStore('cart', {
    state: () => ({
        item: null
    }),

    actions: {
        add(productId) {
            axios
                .post('/cart/add', { product_id: productId })
                .then((response) => {
                    this.item = response.data
                })
        },
        decrement(productId) {
            axios
            .delete('/cart/decrement', { params: { product_id: productId } })
            .then((response) => {
                this.item = response.data;
            })
        }
    }
})