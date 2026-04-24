<template>
    <div>
        <h1>Succès page</h1>
    </div>
</template>

<script>
import { useCartStore } from '../../../src/stores/cartStore';


export default {
    name: 'SuccesPage',
    mounted() {
        useCartStore().cart = null;
    }
}
</script>