<script setup>
import { ref, computed, watch } from 'vue'
import { LogService } from '../services/LogService.js'

const props = defineProps({
  planet: Object,
  vehicle: Object,
  obstacles: Array,
})

const loading = ref(false)



const grid = computed(() => {
  if (!props.planet || !props.vehicle) return []

  const { width, height } = props.planet
  const obstacles = props.obstacles ?? []

  return Array.from({ length: height }, (_, rowIndex) => {
    const y = height - 1 - rowIndex

    return Array.from({ length: width }, (_, x) => {
      const isVehicle =
        props.vehicle.position_x === x &&
        props.vehicle.position_y === y

      const isObstacle = obstacles.some(
        o => o.position_x === x && o.position_y === y
      )

      return { x, y, isVehicle, isObstacle }
    })
  })
})

</script>

<template>
  <div class="inline-block">
    <h3 class="font-bold mb-2">🗺️ Planet Map</h3>

    <table class="border-collapse border border-gray-400">
      <tbody>
        <tr v-for="(row, rowIndex) in grid" :key="rowIndex">
          <td
            v-for="cell in row"
            :key="`${cell.x}-${cell.y}`"
            class="w-5 h-5 border border-gray-300 text-center align-middle"
            :class="{
              'bg-green-200 font-bold': cell.isVehicle,
              'bg-gray-200': cell.isObstacle && !cell.isVehicle,
              'bg-white': !cell.isVehicle && !cell.isObstacle
            }"
          >
            <span v-if="cell.isVehicle">🚗</span>
            <span v-else-if="cell.isObstacle">🪨</span>
          </td>
        </tr>
      </tbody>
    </table>

    <p class="mt-2 text-sm text-gray-600">
      Vehicle position:
      ({{ vehicle.position_x }}, {{ vehicle.position_y }})
      — {{ vehicle.direction }}
    </p>
  </div>
</template>
