<template>
    <table v-if="cart && cart.items && cart.items.length > 0">
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
                
                <td v-if="!readonly">
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
        <button v-if="!readonly" @click="removeCart(cart.id)">Vider le panier</button>
    </section>
</template>

<script>
import { useCartStore } from '../../../src/stores/cartStore';
import { formatPrice } from '../../../src/helpers/format';

export default {
    name: 'PanierDetailsComponent',
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
    props: {
        readonly: {
            type: Boolean,
            default: false
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