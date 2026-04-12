<template>
    <div v-if="cart && cart.items && cart.items.length > 0">
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in cart.items" :key="item.id">
                    <td>{{ item.product.name }}</td>
                    <td>{{ item.quantity }}</td>
                    <td>{{ item.product.price }}€</td>
                    <td>
                        <button @click="add(item.product.id)">+</button>
                        <button @click="decrement(item.product.id)">-</button>
                        <button @click="removeItem(item.product.id)">Supprimer</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <section>
            <p>Total HT - {{ totalHT }}</p>
            <p>Total TTC : {{ totalTTC }}-</p>
            <button @click="removeCart(cart.id)">Vider le panier</button>
        </section>
    </div>
</template>

<script>
import { useCartStore } from '../../../src/stores/cartStore';

export default {
    name: 'PanierComponent',
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