<template layout="AppShell,Authenticated">
  <div class="tw-p-6 tw-mt-10">
    <div>
      <q-btn
        color="purple"
        label="Nova Carteira"
        @click="openModal = true"
      />
    </div>
    <q-card class="my-card tw-mt-10">
      <q-card-section>
        <div class="row q-gutter-md">
          <div
            v-for="wallet in wallets"
            :key="wallet.id"
            class="col-xs-12 col-sm-12 col-md-3"
          >
            <q-card
              dark
              flat
              bordered
            >
              <q-card-section>
                <div class="row items-center no-wrap">
                  <div class="col">
                    <div class="text-h6">
                      {{ wallet.name }}
                    </div>
                    <div class="text-subtitle2">
                      {{ wallet.balance }}
                    </div>
                  </div>

                  <div class="col-auto">
                    <q-btn
                      color="grey-7"
                      round
                      flat
                      push
                    >
                      <div class="row items-center no-wrap">
                        <i:mdi:dots-vertical />
                      </div>

                      <q-menu
                        cover
                        auto-close
                      >
                        <q-list>
                          <q-item clickable>
                            <q-item-section>Remove Card</q-item-section>
                          </q-item>
                          <q-item clickable>
                            <q-item-section>Send Feedback</q-item-section>
                          </q-item>
                          <q-item clickable>
                            <q-item-section>Share</q-item-section>
                          </q-item>
                        </q-list>
                      </q-menu>
                    </q-btn>
                  </div>
                </div>
              </q-card-section>

              <q-separator />

              <q-card-actions>
                <Link :href="route('wallet.show', wallet.id)">
                  <q-btn flat>
                    Gerênciar
                  </q-btn>
                </Link>
              </q-card-actions>
            </q-card>
          </div>
        </div>
      </q-card-section>
    </q-card>

    <q-dialog
      v-model="openModal"
      persistent
    >
      <q-card
        dark
        style="width: 700px; max-width: 80vw;"
      >
        <q-card-section class="row items-center q-pb-none">
          <div class="text-h6">
            {{ (walletForm.name) ? walletForm.name : 'Carteira' }}
          </div>
          <q-space />

          <i:mdi:window-close
            v-close-popup
            class="tw-cursor-pointer"
            width="20"
            height="20"
          />
        </q-card-section>
        <q-card-section class="tw-mt-5">
          <div class="row tw-mb-6 q-gutter-xl justify-center">
            <!-- Name -->
            <div class="col-12 col-sm-6 col-md-3">
              <q-input
                v-model="walletForm.name"
                dark
                filled
                label="Nome"
                placeholder="Quotex, IQ Option"
                lazy-rules
                :rules="[val => !!val || 'Obrigatorio']"
              />
            </div>

            <!-- Initial Balance -->
            <div class="col-12 col-sm-6 col-md-3">
              <q-input
                v-model="walletForm.balance"
                dark
                filled
                label="Saldo inicial"
                placeholder="R$ 100,00"
                lazy-rules
                :rules="[val => !!val || 'Obrigatorio']"
              />
            </div>

            <!-- Currency -->
            <div class="col-12 col-sm-6 col-md-3">
              <q-select
                v-model="walletForm.currency"
                dark
                filled
                :options="currency"
                label="Moeda"
              />
            </div>
          </div>

          <div class="row tw-mb-6 q-gutter-xl justify-center">
            <!-- managementType -->
            <div class="col-12 col-sm-6 col-md-3">
              <q-select
                v-model="walletForm.management_type"
                dark
                filled
                :options="managementTypeOptions"
                label="Gerênciamento"
              />
            </div>

            <!--START MANAGEMENT FIXED-->
            <!-- get Take -->
            <div
              v-if="walletForm.management_type === 'fixed'"
              class="col-12 col-sm-6 col-md-3"
            >
              <q-input
                v-model="walletForm.take_profit"
                dark
                filled
                label="Take"
                placeholder="R$ 26,00"
                lazy-rules
                :rules="[val => !!val || 'Obrigatorio']"
              />
            </div>

            <!-- get Stop -->
            <div
              v-if="walletForm.management_type === 'fixed'"
              class="
              col-12
              col-sm-6
              col-md-3"
            >
              <q-input
                v-model="walletForm.stop_loss"
                dark
                filled
                label="Stop"
                placeholder="R$ 26,00"
                lazy-rules
                :rules="[val => !!val || 'Obrigatorio']"
              />
            </div>
            <!--START MANAGEMENT FIXED-->

            <!--START MANAGEMENT COMPOUND-->
            <!-- get TakePercentage -->
            <div
              v-if="walletForm.management_type === 'compound'"
              class="
              col-12
              col-sm-6
              col-md-3"
            >
              <q-input
                v-model="walletForm.take_percentage"
                dark
                filled
                label="Take %"
                placeholder="15%"
                lazy-rules
                :rules="[val => !!val || 'Obrigatorio']"
              />
            </div>

            <!-- get StopPercentage -->
            <div
              v-if="walletForm.management_type === 'compound'"
              class="
              col-12
              col-sm-6
              col-md-3"
            >
              <q-input
                v-model="walletForm.stop_percentage"
                dark
                filled
                label="Stop %"
                placeholder="5%"
                lazy-rules
                :rules="[val => !!val || 'Obrigatorio']"
              />
            </div>
            <!--START MANAGEMENT COMPOUND-->
          </div>

          <div
            v-if="walletForm.management_type === 'compound'"
            class="q-pa-md"
          >
            <div>
              <q-badge
                class="tw-mr-6"
                color="green"
              >
                Take: {{ walletForm.take_percentage }}%
              </q-badge>
              <q-badge color="green">
                R$: {{ takePercentageCalc }}
              </q-badge>
            </div>

            <q-slider
              v-model="walletForm.take_percentage"
              :min="0"
              color="green"
            />

            <div>
              <q-badge
                class="tw-mr-6"
                color="red"
              >
                Stop: {{ walletForm.stop_percentage }}%
              </q-badge>
              <q-badge color="red">
                R$: {{ stopPercentageCalc }}
              </q-badge>
            </div>

            <q-slider
              v-model="walletForm.stop_percentage"
              :min="0"
              color="red"
            />
          </div>

          <div>
            <q-toggle
              v-model="walletForm.is_main"
              label="Principal"
            />
            <q-toggle
              v-model="walletForm.is_binary"
              label="Opções Binárias ?"
            />
          </div>
        </q-card-section>
        <q-card-section>
          <div class="flex items-center justify-end">
            <q-btn
              color="purple"
              label="Nova Carteira"
              @click="submit"
            />
          </div>
        </q-card-section>
      </q-card>
    </q-dialog>
  </div>
</template>

<script setup>

defineProps({
  title: String,
  wallets: Object
})

const attrs = useAttrs()
const openModal = ref(false)

const currency = ['BRL', 'USD', 'EUR']
const managementTypeOptions = ['fixed', 'compound']

const walletForm = useForm({
  user_id: attrs.auth.user.id,
  name: 'Quotex',
  initial_balance: 0,
  balance: 50,
  management_type: 'fixed',
  take_profit: 0,
  stop_loss: 0,
  take_percentage: 0,
  stop_percentage: 0,
  currency: 'BRL',
  is_main: false,
  is_binary: true,
  add_totals: false
})

const takePercentageCalc = computed(() => ((walletForm.take_percentage / 100) * walletForm.balance).toFixed(2))
const stopPercentageCalc = computed(() => ((walletForm.stop_percentage / 100) * walletForm.balance).toFixed(2))

const submit = () => {
  walletForm.initial_balance = walletForm.balance

  if (walletForm.management_type === 'compound') {
    walletForm.take_profit = takePercentageCalc
    walletForm.stop_loss = stopPercentageCalc
  }

  walletForm.post(route('wallet.store'), {
    onSuccess: (page) => {
      openModal.value = false
    }
  })
}

</script>
