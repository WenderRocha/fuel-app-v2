<template layout="AppShell,Authenticated">
  <div class="tw-p-6">
    <Head :title="title" />

    <!--START TABLE MANAGEMENT RESUME-->
    <q-card class="my-card tw-mt-10">
      <q-card-section class="q-pt-xs">
        <div class="text-overline">
          Book Trade
        </div>
      </q-card-section>
      <q-card-section>
        <div class="q-pa-md">
          <q-table
            :rows="managements"
            :columns="columns"
            :pagination="managementPagination"
            row-key="name"
            no-data-label="Você ainda não iniciou suas operações"
          >
            <template #body="props">
              <q-tr :props="props">
                <q-td
                  key="date"
                  :props="props"
                >
                  <span class="tw-text-cyan-600 tw-font-bold">

                    {{ props.row.created_at }}

                  </span>
                </q-td>
                <q-td
                  key="trades"
                  :props="props"
                >
                  <q-badge color="cyan">
                    {{ props.row.qtd_trades }}
                  </q-badge>
                </q-td>
                <q-td
                  key="score"
                  :props="props"
                >
                  <div class="tw-flex tw-gap-4">
                    <q-badge color="green">
                      {{ props.row.qtd_win }}
                    </q-badge>
                    <q-badge color="orange">
                      {{ props.row.qtd_draw }}
                    </q-badge>
                    <q-badge color="red">
                      {{ props.row.qtd_loss }}
                    </q-badge>
                  </div>
                </q-td>
                <q-td
                  key="win"
                  :props="props"
                >
                  <span class="tw-text-green-600 tw-font-bold">
                    R$ {{ props.row.value_win }}
                  </span>
                </q-td>
                <q-td
                  key="loss"
                  :props="props"
                >
                  <span class="tw-text-red-500 tw-font-bold">
                    R$ {{ props.row.value_loss }}
                  </span>
                </q-td>

                <q-td
                  key="income"
                  :props="props"
                >
                  <span
                    v-show="props.row.result_percentage_day > 0"
                    class="tw-text-emerald-600 tw-font-bold"
                  >
                    R$ {{ props.row.profit }}
                  </span>
                  <span
                    v-show="props.row.result_percentage_day < 0"
                    class="tw-text-red-600 tw-font-bold"
                  >
                    R$ {{ props.row.profit }}
                  </span>
                  <span
                    v-show="props.row.result_percentage_day == 0"
                    class="tw-text-orange-600 tw-font-bold"
                  >
                    R$ {{ props.row.profit }}
                  </span>
                </q-td>
                <q-td
                  key="percentage"
                  :props="props"
                >
                  <q-badge
                    v-if="props.row.result_percentage_day > 0"
                    color="green"
                  >
                    + {{ props.row.result_percentage_day }}%
                  </q-badge>

                  <q-badge
                    v-else
                    color="red"
                  >
                    {{ props.row.result_percentage_day }}%
                  </q-badge>
                </q-td>

                <q-td
                  key="initial_balance"
                  :props="props"
                >
                  <q-badge color="blue">
                    R$ {{ props.row.day_balance }}
                  </q-badge>
                </q-td>

                <q-td
                  key="final_balance"
                  :props="props"
                >
                  <q-badge color="blue">
                    R$ {{ props.row.final_balance }}
                  </q-badge>
                </q-td>
                <q-td
                  key="result_day"
                  :props="props"
                >
                  <q-badge
                    v-show="props.row.result_day === 'win'"
                    title="Win"
                    color="green"
                  >
                    <i:mdi:check-circle />
                    &nbsp;
                    Win
                  </q-badge>
                  <q-badge
                    v-show="props.row.result_day === 'loss'"
                    color="red"
                  >
                    <i:mdi:close-circle />
                    &nbsp;
                    Loss
                  </q-badge>
                  <q-badge
                    v-show="props.row.result_day === 'draw'"
                    color="orange"
                  >
                    <i:mdi:pause-circle />
                    &nbsp;
                    Empate
                  </q-badge>
                </q-td>
                <q-td>
                  <Link :href="route('wallet.show', props.row.wallet_id)">
                    Abrir
                  </Link>
                </q-td>
              </q-tr>
            </template>
          </q-table>
        </div>
      </q-card-section>
    </q-card>
    <!--END TABLE MANAGEMENT RESUME-->
  </div>
</template>

<script setup>
defineProps({
  title: String,
  managements: String
})

// tables management columns
const columns = [
  {
    name: 'date',
    label: 'Data',
    align: 'center'
  },
  { name: 'trades', align: 'center', label: 'QTD Trades', field: 'trades' },
  { name: 'score', align: 'left', label: 'Placar', field: 'score' },
  { name: 'win', align: 'center', label: 'Win', field: 'win' },
  { name: 'loss', align: 'center', label: 'Loss', field: 'loss' },
  { name: 'income', align: 'center', label: 'Renda', field: 'income' },
  { name: 'percentage', align: 'center', label: 'Retorno Dia (%)', field: 'percentage' },
  { name: 'initial_balance', align: 'center', label: 'Saldo inicial', field: 'initial_balance' },
  { name: 'final_balance', align: 'center', label: 'Saldo final', field: 'final_balance' },
  { name: 'result_day', align: 'center', label: 'Resultado', field: 'result_day' },
  { name: 'management', align: 'center', label: 'Gerênciar', field: 'management' }
]

</script>
