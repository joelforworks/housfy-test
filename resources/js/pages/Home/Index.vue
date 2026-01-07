<script setup>
import { ref, computed, watch } from 'vue'
import { LogService  } from '../../services/LogService.js'
import PlanetMap from '../../components/PlanetMap.vue'
import LogHistory from '../../components/LogHistory.vue'

const props = defineProps({
    planets: {
        type: Array,
        default: () => []
    },
    teams: {
        type: Array,
        default: () => []
    },
    vehicles: {
        type: Array,
        default: () => []
    }
})

const selectedPlanet = ref(null)
const selectedTeam = ref(null)
const selectedVehicle = ref(null)
const selectedCommand = ref('')
const logHistory = ref(null)
const obstacles = ref([]);
const obstaclesArray = ref([]);
const loading = ref(false);

// Filter vehicles based on selected planet and team
const filteredVehicles = computed(() => {
    if (!props.vehicles || !props.vehicles.length) return []

    return props.vehicles.filter(vehicle => {
        // If no planet or team selected, show all vehicles
        if (!selectedPlanet.value && !selectedTeam.value) return true

        let matchesPlanet = true
        let matchesTeam = true

        if (selectedPlanet.value) {
            matchesPlanet = vehicle.planet_id === selectedPlanet.value.id || 
                vehicle.planet?.id === selectedPlanet.value.id
        }

        if (selectedTeam.value) {
            matchesTeam = vehicle.team_id === selectedTeam.value.id || 
                vehicle.team?.id === selectedTeam.value.id
        }

        return matchesPlanet && matchesTeam
    })
})
const isValidCommand = computed(() =>
    /^[FLR]*$/.test(selectedCommand.value.toUpperCase())
)

watch([selectedPlanet, selectedTeam], () => {
  selectedVehicle.value = null

  if (filteredVehicles.value.length === 1) {
    selectedVehicle.value = filteredVehicles.value[0]
  }

  if (selectedPlanet.value) {
    loadObstacles(selectedPlanet.value.id)
  } else {
    obstacles.value = []
  }
})

watch(selectedVehicle, (vehicle) => {
  if (!vehicle) {
    logHistory.value = null
    return
  }

  loadLogHistory(vehicle.id)
})

const loadObstacles = async (planet_id) => {
  try {
    loading.value = true

    const response = await LogService.generateObstacles(planet_id);

    obstacles.value = (response ?? []).map(([x, y]) => ({
      position_x: Number(x),
      position_y: Number(y),
    }))
    obstaclesArray.value = response;

  } catch (error) {
    console.error('Failed to load obstacles:', error)
    obstacles.value = []
  } finally {
    loading.value = false
  }
}

const loadLogHistory = async (vehicleId) => {
  if (!vehicleId) {
    logHistory.value = null
    return
  }

  try {
    loading.value = true

    const response = await LogService.logs(vehicleId)

    logHistory.value = response ?? [];

  } catch (error) {
    console.error('Failed to load log history:', error)
    logHistory.value = []
  } finally {
    loading.value = false
  }
}


const send = async () => {

  const commandToArrayValue = selectedCommand.value.split('')

  try {
    loading.value = true

    const response = await LogService.send({
      command: commandToArrayValue,
      vehicle_id: selectedVehicle.value.id,
      obstacles:obstaclesArray.value
    })

    if (response?.data?.vehicle) {
      selectedVehicle.value = {
        ...selectedVehicle.value,
        ...response.data.vehicle
      }
    }
    if (response?.data?.logs) {
      logHistory.value = response.data.logs
    }

    console.log('Command executed:', response)
  } catch (error) {
    console.error('Failed to send command:', error)

  } finally {
    loading.value = false
    selectedCommand.value = '' 
    if(logHistory.value[0].success == false){
        alert("Vehicle found a obstacle command oborted.");
    }
  }
}

</script>

<template>
    <div class="flex p-3  justify-center content-between ">
        <div>
            <div>
                <label class="block mb-2 font-medium">Select a Team:</label>
                <Select
                    v-model="selectedTeam"
                    :options="teams"
                    optionLabel="name"
                    placeholder="Select a Team"
                    class="w-full md:w-56"
                    showClear
                    />
                    <p v-if="selectedTeam" class="mt-1 text-sm text-gray-600">
                        Selected: {{ selectedTeam.name }}
                    </p>
            </div>

            <div>
                <label class="block mb-2 font-medium">Select a Planet:</label>
                <Select
                    v-model="selectedPlanet"
                    :options="planets"
                    optionLabel="name"
                    placeholder="Select a Planet"
                    class="w-full md:w-56"
                    showClear
                    />
                    <p v-if="selectedPlanet" class="mt-1 text-sm text-gray-600">
                        Selected: {{ selectedPlanet.name }}
                    </p>
            </div>


            <div>
                <label class="block mb-2 font-medium">Select a Vehicle:</label>
                <Select
                    v-model="selectedVehicle"
                    :options="filteredVehicles"
                    optionLabel="name"
                    placeholder="Select a Vehicle"
                    class="w-full md:w-56"
                    :disabled="!filteredVehicles.length"
                    showClear
                    />
                    <p v-if="selectedVehicle" class="mt-1 text-sm text-gray-600">
                        Selected: {{ selectedVehicle.name }}
                    </p>
                    <p v-if="filteredVehicles.length === 0" class="mt-1 text-sm text-yellow-600">
                        No vehicles available for the selected planet and team
                    </p>
                    <p v-else class="mt-1 text-sm text-gray-600">
                        {{ filteredVehicles.length }} vehicle(s) available
                    </p>
            </div>

            <!-- Display selected information -->
            <div v-if="selectedPlanet || selectedTeam || selectedVehicle" class="mt-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="font-bold mb-2">Selection Summary:</h3>
                <p v-if="selectedPlanet">🌍 Planet: {{ selectedPlanet.name }}</p>
                <p v-if="selectedTeam">👥 Team: {{ selectedTeam.name }}</p>
                <p v-if="selectedVehicle">🚗 Vehicle: {{ selectedVehicle.name }}</p>
            </div>
        </div>
        <div class="flex flex-col">
            <InputGroup>
                <Button
                    :disabled="!isValidCommand || !selectedVehicle"
                    type="button" 
                    label="Send" 
                    icon="pi pi-send" 
                    :loading="loading" 
                    @click="send" 
                />
                <InputText 
                    placeholder="Command"  
                    v-model="selectedCommand"
                    @input="selectedCommand = selectedCommand.toUpperCase()"
                />
            </InputGroup>
            <PlanetMap
                v-if="selectedPlanet && selectedVehicle"
                :planet="selectedPlanet"
                :vehicle="selectedVehicle"
                :obstacles="obstacles"
            />
            
        </div>
        <div>
            <LogHistory 
                v-if="logHistory && logHistory"
                :elements="logHistory"
            />
        </div>

    </div>

</template>
