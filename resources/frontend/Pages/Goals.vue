<template layout="AppShell,Authenticated">
  <div class="tw-p-6">
    <Head :title="title" />

    <h1 class="text-h4">
      {{ title }}
    </h1>
    <q-btn
      label="Close Icon"
      color="primary"
      @click="showModal = true"
    />

    <q-card
      v-for="goal in goals"
      :key="goal.id"
      class="my-card tw-mt-10"
    >
      <q-card-section>
        <div class="row q-gutter-lg tw-justify-center">
          <div class="col-xs-12 col-sm-2 col-md-3">
            <q-card class="my-card bg-grey-9">
              <div class="flex justify-center">
                <q-circular-progress
                  show-value
                  class="text-white q-ma-md"
                  :value="goal.progress"
                  size="100px"
                  color="white"
                />
              </div>

              <q-card-section>
                <div class="row no-wrap items-center">
                  <div class="col text-h6 tw-text-white ellipsis">
                    {{ goal.name }}
                  </div>
                </div>
              </q-card-section>

              <q-card-section class="q-pt-none">
                <div class="text-subtitle1 tw-text-white">
                  R$ {{ goal.initial_value }} / R$ {{ goal.value }}
                </div>
                <div class="text-caption text-grey">
                  {{ formattedDate(goal.date_final) }}
                </div>
              </q-card-section>
            </q-card>
          </div>
        </div>
      </q-card-section>
    </q-card>

    <q-dialog v-model="showModal">
      <q-card style="width: 700px; max-width: 80vw;">
        <q-card-section class="row items-center q-pb-none">
          <div class="text-h6">
            Novo objetivo
          </div>
          <q-space />
          <i:mdi:window-close
            v-close-popup
            class="tw-cursor-pointer"
            width="20"
            height="20"
          />
        </q-card-section>

        <q-card-section>
          <div>
            <q-form
              @submit="onSubmit"
              @reset="onReset"
            >
              <div class="row q-gutter-md">
                <q-input
                  v-model="goalForm.name"
                  class="col tw-mb-3"
                  filled
                  label="Nome do Objetivo *"
                  lazy-rules
                  :rules="[ val => val && val.length > 0 || 'Campo Obrigatório']"
                />
                <q-input
                  v-model="goalForm.value"
                  class="col tw-mb-3"
                  filled
                  label="Valor do Objetivo *"
                  lazy-rules
                  :rules="[ val => val && val.length > 0 || 'Campo Obrigatório']"
                />
              </div>
              <div class="row q-gutter-md">
                <q-select
                  v-if="profitWallet"
                  v-model="goalForm.wallet"
                  class="col tw-mb-3"
                  filled
                  :options="['Quotex', 'IQ Option', 'Binomo']"
                  label="Carteira"
                />
                <q-input
                  v-else
                  v-model="goalForm.initial_value"
                  class="col tw-mb-3"
                  filled
                  label="Valor inicial *"
                  lazy-rules
                  :rules="[ val => val && val.length > 0 || 'Please type something']"
                />

                <q-input
                  v-model="goalForm.date_final"
                  class="col tw-mb-3"
                  filled
                  type="date"
                  hint="Data para conclusão do objetivo"
                />
              </div>

              <q-toggle
                v-model="profitWallet"
                label="Valor inicial apartir do lucro de uma carteira"
              />

              <div class="tw-mt-10">
                <q-btn
                  :disable="goalForm.processing"
                  :loading="goalForm.processing"
                  label="Salvar"
                  type="submit"
                  color="primary"
                />
              </div>
            </q-form>
          </div>
        </q-card-section>
      </q-card>
    </q-dialog>
  </div>
</template>

<script setup>
defineProps({
  title: String,
  wallets: Object,
  goals: Object
})

const showModal = ref(false)
const profitWallet = ref(false)

const selectedWallet = ref('Selecione a carteira')

const goalForm = useForm({
  wallet: 'Selecione a carteira',
  name: '',
  initial_value: '',
  value: '',
  description: '',
  date_final: ''
})

function onSubmit () {
  goalForm.post(route('goals.store'))
}
function onReset () {

}

function formattedDate (date) {
  return new Date(date).toLocaleString('pt-BR')
}
</script>
