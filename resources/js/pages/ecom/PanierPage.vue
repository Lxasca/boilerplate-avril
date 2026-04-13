<template>
    <div>
        <h1>Panier</h1>

        {{ cart }}
    </div>
</template>

<script>
import axios from 'axios';
import { useCartStore } from '../../../src/stores/cartStore';

export default {
    name: 'PanierPage',
    computed: {
        cart() {
            return useCartStore().cart
        }
    }
} 
</script>