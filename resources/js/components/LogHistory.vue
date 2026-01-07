<script setup>
import { computed } from 'vue'

const props = defineProps({
  elements: {
    type: Array,
    required: true,
    default: () => []
  }
})

</script>

<template>
  <div class="w-full max-w-full">
    <h3 class="font-bold mb-2">📜 Log History</h3>

    <div
      v-if="elements.length"
      class="space-y-2 max-h-64 overflow-auto"
    >
      <div
        v-for="log in elements"
        :key="log.id"
        :class="[
          'p-3 rounded border flex justify-between items-center',
          log.success
            ? 'bg-green-50 border-green-200'
            : 'bg-red-50 border-red-200'
        ]"
      >
        <span class="font-mono text-sm">
          {{ log.command }}
        </span>

        <span class="font-mono text-sm">
          {{ log.position_x }} , {{log.position_y }}
        </span>

        <span class="text-xs text-gray-500">
          {{ log.created_at }}
        </span>
      </div>
    </div>

    <p v-else class="text-sm text-gray-500 italic">
      No logs available for this vehicle
    </p>
  </div>
</template>
