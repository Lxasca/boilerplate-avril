<template>
    <div v-if="item">
        {{ item }}
    </div>
</template>

<script>
import { useCartStore } from '../../../src/stores/cartStore';

export default {
    name: 'PanierComponent',
    computed: {
        item() {
            return useCartStore().item
        }
    },
}

</script>