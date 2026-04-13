<template>
    <div v-if="isShowCart && cart && cart.items && cart.items.length > 0">
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Prix total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in cart.items" :key="item.id">
                    <td>{{ item.product.name }}</td>
                    <td>{{ item.quantity }}</td>
                    <td>{{ formatPrice(item.product.price) }}</td>
                    <td>{{ formatPrice(item.product.price * item.quantity) }}</td>
                    <td>
                        <button @click="add(item.product.id)">+</button>
                        <button @click="decrement(item.product.id)">-</button>
                        <button @click="removeItem(item.product.id)">Supprimer</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <section>
            <p>Total HT - {{ formatPrice(totalHT) }}</p>
            <p>Total TTC : {{ formatPrice(totalTTC) }}</p>
            <button @click="removeCart(cart.id)">Vider le panier</button>
        </section>

        <section>
            <router-link :to="{ name: 'panier' }">
                Mon panier
            </router-link>
        </section>
    </div>
</template>

<script>
import { useCartStore } from '../../../src/stores/cartStore';
import { formatPrice } from '../../../src/helpers/format';

export default {
    name: 'PanierComponent',
    props: {
        isShowCart: {
            type: Boolean,
            required: true
        }
    },
    computed: {
        cart() {
            return useCartStore().cart
        },
        totalHT() {
            return useCartStore().totalHT
        },
        totalTTC() {
            return useCartStore().totalTTC
        }
    },
    methods: {
        formatPrice,
        add(productId) {
            const cartStore = useCartStore();
            cartStore.add(productId);
        },
        decrement(productId) {
            const cartStore = useCartStore();
            cartStore.decrement(productId);
        },
        removeItem(productId) {
            const cartStore = useCartStore();
            cartStore.removeItem(productId);
        },
        removeCart(cartId) {
            const cartStore = useCartStore();
            cartStore.removeCart(cartId);
        },
    }
}

</script>