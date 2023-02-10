<template layout="AppShell,Authenticated">
  <div class="tw-p-6 tw-mt-10">
    <Head :title="title" />

    <!--START TITLE PAGE AND BUTTON ACTION-->
    <div class="tw-flex tw-items-center tw-justify-between">
      <div>
        <span class="text-h6 tw-mb-10">
          {{ title }} {{ setDataBar }}
        </span>
      </div>

      <q-btn
        color="dark"
        @click="openModal = true"
      >
        <i:mdi:finance
          width="30"
          height="30"
          class="tw-mr-3"
        />
        <div>Iniciar trade</div>
      </q-btn>
    </div>
    <!--START TITLE PAGE AND BUTTON ACTION-->

    <!--START CALENDAR VIEW-->
    <q-card class="my-card tw-mt-10">
      <q-card-section>
        <div class="">
          <v-date-picker
            v-model="calendarDate"
            timezone="America/Sao_Paulo"
            :attributes="calendarAttributes"
            mode="date"
            data="YYYY-MM-DD"
            :is-dark="settings.isDark"
            is-expanded
          />
        </div>
      </q-card-section>
      <q-card-section class="text-center">
        <q-badge
          color="blue"
          rounded
          class="q-mr-sm"
        /> Hoje

        <q-badge
          color="red"
          rounded
          class="q-mr-sm tw-ml-2"
        />Negativo

        <q-badge
          color="green"
          rounded
          class="q-mr-sm tw-ml-2"
        />Positivo

        <q-badge
          color="orange"
          rounded
          class="q-mr-sm tw-ml-2"
        />Empate

        <q-badge
          color="grey"
          rounded
          class="q-mr-sm tw-ml-2"
        />S/Operar
      </q-card-section>
    </q-card>
    <!--END CALENDAR VIEW-->

    <!--START MANAGEMENTS CARDS VIEW-->
    <q-card class="my-card tw-p-3 tw-mt-10">
      <q-card-section class="q-pt-xs flex tw-justify-between">
        <div class="text-overline">
          Banca
        </div>
        <div class="text-overline">
          <i:mdi:cog-outline
            class="tw-cursor-pointer"
            width="30"
            height="30"
            title="Ajustar Banca"
          />
        </div>
      </q-card-section>
      <q-card-section>
        <div class="row q-gutter-lg tw-flex tw-justify-center tw-items-center">
          <div class="col-xs-12 col-sm-2 col-md-2">
            <q-card class="my-card bg-grey-6 text-white tw-mt-5">
              <q-card-section class="flex items-center justify-center q-gutter-md">
                <div>
                  <i:mdi:bank-outline
                    width="30"
                    height="30"
                  />
                </div>
                <div>
                  <div class="flex items-center text-h6">
                    Saldo Inicial
                  </div>
                  <div class="text-h6 text-weight-bolder">
                    <span class="tw-text-sm text-weight-bolder">
                      {{ setCurrencySymbol }}
                    </span> {{ wallet.initial_balance }}
                  </div>
                </div>
              </q-card-section>
            </q-card>
          </div>
          <div class="col-xs-12 col-sm-2 col-md-2 tw-mt-3">
            <q-card class="my-card bg-blue-6 text-white tw-mt-5">
              <q-card-section class="flex items-center justify-center q-gutter-md">
                <div>
                  <i:mdi:wallet-outline
                    width="30"
                    height="30"
                  />
                </div>
                <div>
                  <div class="flex items-center justify-center text-h6">
                    Saldo atual
                  </div>
                  <div class="text-h6 text-weight-bolder">
                    <span class="tw-text-sm text-weight-bolder"> {{ setCurrencySymbol }}</span> {{ wallet.balance }}
                  </div>
                </div>
                <div class="flex tw-justify-center items-center tw-w-full">
                  <span
                    v-show="wallet.result_percentage > 0"
                    class="tw-text-sm tw-font-bold flex items-center"
                  >
                    <i:mdi:arrow-up-bold />  {{ wallet.result_percentage }}%
                  </span>
                  <span
                    v-show="wallet.result_percentage < 0"
                    class="tw-text-sm tw-font-bold flex items-center"
                  >
                    <i:mdi:arrow-down-bold />  {{ wallet.result_percentage }}%
                  </span>
                </div>
              </q-card-section>
            </q-card>
          </div>
          <div class="col-xs-12 col-sm-2 col-md-2 tw-mt-3">
            <q-card class="my-card bg-green-6 text-white tw-mt-5">
              <q-card-section class="flex items-center justify-center q-gutter-md">
                <div>
                  <i:mdi:hand-coin-outline
                    width="30"
                    height="30"
                  />
                </div>
                <div>
                  <div class="flex items-center text-h6">
                    Resultado
                  </div>
                  <div class="text-h6 text-weight-bolder">
                    <span class="tw-text-sm text-weight-bolder"> {{ setCurrencySymbol }}</span> {{ setDataBar = wallet.profit }}
                  </div>
                </div>
                <div class="tw-w-full text-center">
                  <span
                    class="tw-text-sm tw-font-bold"
                  > Média lucro dia:  {{ setCurrencySymbol }} {{ wallet.average_profit }}</span>
                </div>
              </q-card-section>
            </q-card>
          </div>
          <div class="col-xs-12 col-sm-2 col-md-2 tw-mt-3">
            <q-card class="my-card bg-dark text-white tw-mt-5">
              <q-card-section class="flex items-center justify-center q-gutter-md">
                <div>
                  <i:mdi:bullseye-arrow
                    width="30"
                    height="30"
                  />
                </div>
                <div>
                  <div class="flex items-center text-h6">
                    Take Profit
                  </div>
                  <div class="text-h6 text-weight-bolder">
                    <span class="tw-text-sm text-weight-bolder"> {{ setCurrencySymbol }}</span> {{ wallet.take_profit }}
                  </div>
                </div>
                <div
                  v-show="wallet.management_type === 'compound'"
                >
                  <span
                    class="tw-text-sm tw-font-bold"
                  >{{ wallet.take_percentage }}%</span>
                </div>
              </q-card-section>

              <q-card-section>
                <q-linear-progress
                  dark
                  stripe
                  rounded
                  size="25px"
                  :value="takeProgress"
                  color="green"
                >
                  <div class="absolute-full flex flex-center">
                    <q-badge
                      color="white"
                      text-color="dark"
                      :label="takeProgressLabel"
                    />
                  </div>
                </q-linear-progress>
              </q-card-section>
            </q-card>
          </div>
          <div class="col-xs-12 col-sm-2 col-md-2 tw-mt-3">
            <q-card class="my-card bg-red-5 text-white tw-mt-5">
              <q-card-section class="flex items-center justify-center q-gutter-md">
                <div>
                  <i:mdi:alert-octagon-outline
                    width="30"
                    height="30"
                  />
                </div>
                <div>
                  <div class="flex items-center text-h6">
                    Stop Loss
                  </div>
                  <div

                    class="text-h6 text-weight-bolder"
                  >
                    <span class="tw-text-sm text-weight-bolder"> {{ setCurrencySymbol }}</span> {{ wallet.stop_loss }}
                  </div>
                </div>
                <div v-show="wallet.management_type === 'compound'">
                  <span
                    class="tw-text-sm tw-font-bold"
                  >{{ wallet.stop_percentage }}%</span>
                </div>
              </q-card-section>

              <q-card-section>
                <q-linear-progress
                  dark
                  stripe
                  rounded
                  size="25px"
                  :value="stopProgress"
                  color="dark"
                >
                  <div class="absolute-full flex flex-center">
                    <q-badge
                      color="dark"
                      text-color="white"
                      :label="stopProgressLabel"
                    />
                  </div>
                </q-linear-progress>
              </q-card-section>
            </q-card>
          </div>
        </div>
      </q-card-section>
    </q-card>
    <!--END MANAGEMENTS CARDS VIEW-->

    <!--START CHARTS-->
    <q-card class="my-card tw-mt-10">
      <q-card-section>
        <div class="row">
          <div class="col-12 col-md-6">
            <v-chart
              ref="bar"
              class="chart"
              :option="monthOption"
              :update-options="monthOption"
              :loading="false"
              :theme="(settings.isDark) ? 'dark-theme' : 'light-theme'"
              autoresize
            />
          </div>

          <div class="col-12 col-md-6">
            <v-chart
              class="chart"
              :option="assertivenessOption"
              :loading="false"
              :theme="(settings.isDark) ? 'pie-dark-theme' : 'pie-light-theme'"
              autoresize
            />
          </div>
        </div>
      </q-card-section>
    </q-card>
    <!--END CHARTS-->

    <!--START TABLE MANAGEMENT RESUME-->
    <q-card class="my-card tw-mt-10">
      <q-card-section class="q-pt-xs">
        <div class="text-overline">
          Resumo de Hoje
        </div>
      </q-card-section>
      <q-card-section>
        <div class="q-pa-md">
          <q-table
            :rows="management"
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

                    {{ formattedDate }}

                  </span>
                </q-td>
                <q-td
                  key="trades"
                  :props="props"
                >
                  <span class="tw-font-bold">
                    {{ props.row.qtd_trades }}
                  </span>
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
                    {{ setCurrencySymbol }} {{ props.row.value_win }}
                  </span>
                </q-td>
                <q-td
                  key="loss"
                  :props="props"
                >
                  <span class="tw-text-red-500 tw-font-bold">
                    {{ setCurrencySymbol }} {{ props.row.value_loss }}
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
                    {{ setCurrencySymbol }} {{ props.row.profit }}
                  </span>
                  <span
                    v-show="props.row.result_percentage_day < 0"
                    class="tw-text-red-600 tw-font-bold"
                  >
                    {{ setCurrencySymbol }} {{ props.row.profit }}
                  </span>
                  <span
                    v-show="props.row.result_percentage_day == 0"
                    class="tw-text-orange-600 tw-font-bold"
                  >
                    {{ setCurrencySymbol }} {{ props.row.profit }}
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
                    {{ setCurrencySymbol }} {{ props.row.day_balance }}
                  </q-badge>
                </q-td>

                <q-td
                  key="final_balance"
                  :props="props"
                >
                  <q-badge color="blue">
                    {{ setCurrencySymbol }} {{ props.row.final_balance }}
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
              </q-tr>
            </template>
          </q-table>
        </div>
        <div class="text-center">
          <Link :href="route('book.index')">
            Book Trade
          </Link>
        </div>
      </q-card-section>
    </q-card>
    <!--END TABLE MANAGEMENT RESUME-->

    <!--START TABLE LAST TRADES-->
    <q-card class="my-card tw-mt-10">
      <q-card-section class="q-pt-xs">
        <div class="text-overline">
          Trades
        </div>
      </q-card-section>
      <q-card-section>
        <div class="q-pa-md">
          <q-table
            :rows="trades"
            :columns="tradeColumns"
            :pagination="tradePagination"
            row-key="name"
            no-data-label="Você ainda não realizou nenhum trade."
          >
            <template #body="props">
              <q-tr :props="props">
                <q-td
                  key="date"
                  :props="props"
                >
                  <span class="tw-text-cyan-600 tw-font-bold">
                    {{ formattedDateTrades(props.row.created_at) }}
                  </span>
                </q-td>
                <q-td
                  key="assets"
                  :props="props"
                >
                  {{ props.row.assets }}
                </q-td>
                <q-td
                  key="payout"
                  :props="props"
                >
                  <div class="tw-flex tw-gap-4">
                    {{ props.row.payout }}%
                  </div>
                </q-td>
                <q-td
                  key="value"
                  :props="props"
                >
                  <span class="tw-text-cyan-600 tw-font-bold">
                    {{ setCurrencySymbol }} {{ props.row.value }}
                  </span>
                </q-td>
                <q-td
                  key="income"
                  :props="props"
                >
                  <span
                    v-show="props.row.trade_result === 'win'"
                    class="tw-text-green-600 tw-font-bold"
                  >
                    {{ setCurrencySymbol }} {{ props.row.income }}
                  </span>
                  <span
                    v-show="props.row.trade_result === 'loss'"

                    class="tw-text-red-600 tw-font-bold"
                  >
                    {{ setCurrencySymbol }} {{ props.row.income }}
                  </span>
                  <span
                    v-show="props.row.trade_result === 'draw'"

                    class="tw-text-orange-600 tw-font-bold"
                  >
                    {{ setCurrencySymbol }} {{ props.row.income }}
                  </span>
                </q-td>

                <q-td
                  key="order_type"
                  :props="props"
                >
                  <span
                    v-if="props.row.order_type === 'CALL'"
                    class="tw-text-green-600 tw-font-semibold"
                  >

                    COMPRA
                  </span>

                  <span
                    v-else
                    class="tw-text-red-600 tw-font-semibold"
                  >

                    VENDA
                  </span>
                </q-td>
                <q-td
                  key="operational"
                  :props="props"
                >
                  {{ props.row.operational }}
                </q-td>

                <q-td
                  key="trade_result"
                  :props="props"
                >
                  <q-badge
                    v-show="props.row.trade_result === 'win'"
                    title="Win"
                    color="green"
                    @click="setDataBar = wallet.profit"
                  >
                    <i:mdi:check-circle />
                    &nbsp;
                    Win
                  </q-badge>
                  <q-badge
                    v-show="props.row.trade_result === 'loss'"
                    color="red"
                  >
                    <i:mdi:close-circle />
                    &nbsp;
                    Loss
                  </q-badge>
                  <q-badge
                    v-show="props.row.trade_result === 'draw'"
                    color="orange"
                  >
                    <i:mdi:pause-circle />
                    &nbsp;
                    Empate
                  </q-badge>
                </q-td>
              </q-tr>
            </template>
          </q-table>
        </div>
        <div class="text-center">
          <a href="#">Ver todos</a>
        </div>
      </q-card-section>
    </q-card>
    <!--END TABLE LAST TRADES-->

    <!--START MODAL REGISTER NEW TRADE-->
    <q-dialog
      v-model="openModal"
      class=""
      persistent
    >
      <q-card
        style="width: 700px; max-width: 80vw;"
        dark
      >
        <q-card-section class="row items-center q-pb-none">
          <div class="text-h6">
            Trade {{ barData }}
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
          <div class="tw-mb-3">
            <q-linear-progress
              dark
              stripe
              rounded
              size="25px"
              :value="takeProgress"
              color="green"
            >
              <div class="absolute-full flex flex-center">
                <q-badge
                  color="dark"
                  text-color="white"
                  :label="takeProgressLabel"
                />
              </div>
            </q-linear-progress>
          </div>
          <div>
            <q-linear-progress
              dark
              stripe
              rounded
              size="25px"
              :value="stopProgress"
              color="red"
            >
              <div class="absolute-full flex flex-center">
                <q-badge
                  color="dark"
                  text-color="white"
                  :label="stopProgressLabel"
                />
              </div>
            </q-linear-progress>
          </div>
        </q-card-section>

        <q-card-section
          v-if="!(targetTake || targetStop)"
          class="tw-mt-5"
        >
          <q-form
            @submit="submit"
            @reset=""
          >
            <div class="row tw-mb-6 q-gutter-xl justify-center">
              <!-- assets -->
              <div class="col-12 col-sm-6 col-md-3">
                <q-select
                  v-model="tradeForm.assets"
                  dark
                  filled
                  :options="assetsOptions"
                  label="Ativo"
                  :rules="[val => !!val || 'Obrigatorio']"
                />
              </div>

              <!-- payout -->
              <div class="col-12 col-sm-6 col-md-3">
                <q-input
                  v-model="tradeForm.payout"
                  dark
                  filled
                  label="Payout %"
                  hint="Apenas números"
                  lazy-rules
                  :rules="[val => !!val || 'Obrigatorio']"
                  @keyup="calcIncome"
                />
              </div>

              <!-- value -->
              <div class="col-12 col-sm-6 col-md-3">
                <q-input
                  v-model="tradeForm.value"
                  color="blue"
                  label-color="blue"
                  dark
                  filled
                  label="Entrada"
                  input-class="text-right"
                  @keyup="calcIncome"
                />
              </div>
            </div>

            <div class="row tw-mb-6 q-gutter-xl justify-center">
              <!-- income -->
              <div class="col-12 col-sm-6 col-md-3">
                <q-input
                  v-model="tradeForm.income"
                  label-color="green"
                  dark
                  disable
                  filled
                  label="Lucro"
                  input-class="text-right"
                />
              </div>

              <!-- soros 1 -->
              <div class="col-12 col-sm-6 col-md-3">
                <q-input
                  v-model="soros"
                  label-color="orange"
                  dark
                  disable
                  filled
                  label="Soros"
                  input-class="text-right"
                />
              </div>

              <!-- income  -->
              <div class="col-12 col-sm-6 col-md-3">
                <q-input
                  v-model="sorosIncome"
                  label-color="green"
                  dark
                  disable
                  filled
                  label="Lucro total"
                  input-class="text-right"
                />
              </div>
            </div>

            <div class="row tw-mb-6 q-gutter-xl justify-center">
              <!-- operational -->
              <div class="col-12 col-sm-6 col-md-3">
                <q-select
                  v-model="tradeForm.operational"
                  dark
                  filled
                  :options="operationalOptions"
                  label="Operacional"
                />
              </div>

              <!-- order type -->
              <div class="col-12 col-sm-6 col-md-3">
                <q-select
                  v-model="tradeForm.order_type"
                  dark
                  filled
                  :options="orderTypeOptions"
                  label="Tipo de Ordem"
                />
              </div>

              <!--observation-->
              <div class="col-12 col-sm-6 col-md-3">
                <q-input
                  v-model="tradeForm.observation"
                  dark
                  filled
                  label="Observação"
                  autogrow
                  type="textarea"
                />
              </div>
            </div>

            <div class="row q-gutter-md justify-center tw-mt-10">
              <q-btn
                :disable="tradeForm.processing"
                :loading="tradeForm.processing"
                type="submit"
                label="WIN"
                size="md"
                color="green"
                @click="getTradeResult = 'win'"
              />

              <q-btn
                :disable="tradeForm.processing"
                :loading="tradeForm.processing"
                type="submit"
                label="EMPATE"
                size="md"
                color="orange"
                @click="getTradeResult = 'draw'"
              />

              <q-btn
                :disable="tradeForm.processing"
                :loading="tradeForm.processing"
                type="submit"
                label="LOSS"
                size="md"
                color="red"
                @click="getTradeResult = 'loss'"
              />
            </div>
          </q-form>
        </q-card-section>

        <!--show stop-->
        <q-card-section v-if="targetStop">
          <q-card
            dark
            bordered
            class="bg-red-9 my-card"
          >
            <q-card-section>
              <div class="text-h6">
                STOP ATINGIDO
              </div>
            </q-card-section>

            <q-separator
              dark
              inset
            />

            <q-card-section>
              Respeite seu gerenciamento e volte amanhã, nada como um dia após o outro!
            </q-card-section>
          </q-card>
        </q-card-section>
        <!--show stop-->

        <!--show take-->
        <q-card-section v-if="targetTake">
          <q-card
            dark
            bordered
            class="bg-green-9 my-card"
          >
            <q-card-section>
              <div class="text-h6 text-center">
                Parabens! é Take!
              </div>
            </q-card-section>

            <q-separator
              dark
              inset
            />

            <q-card-section class="flex justify-center">
              Você bateu sua meta, nada de ganância foco na consistência. nada como um dia após o outro!
              <img
                src="/img/climbing-stairs.png"
                style="width:250px"
              >
            </q-card-section>
          </q-card>
        </q-card-section>
        <!--show take-->
      </q-card>
    </q-dialog>
    <!--END MODAL REGISTER NEW TRADE-->
  </div>
</template>

<script setup>

import { useAppShell } from '@/store/app-shell'
import { use, registerTheme } from 'echarts/core'
import { CanvasRenderer } from 'echarts/renderers'
import { PieChart, BarChart } from 'echarts/charts'
import { TitleComponent, TooltipComponent, LegendComponent, GridComponent } from 'echarts/components'
import VChart from 'vue-echarts'

// custom theme
import lightTheme from '@/echarts/lightTheme.json'
import darkTheme from '@/echarts/darkTheme.json'

// custom theme
import pieLightTheme from '@/echarts/pieLightTheme.json'
import pieDarkTheme from '@/echarts/pieDarkTheme.json'

// register custom themes
registerTheme('pie-dark-theme', pieDarkTheme)
registerTheme('pie-light-theme', pieLightTheme)
registerTheme('dark-theme', darkTheme)
registerTheme('light-theme', lightTheme)

// get settings theme mode light or dark
const { settings } = useAppShell()

// use components echarts
use([
  CanvasRenderer,
  PieChart,
  BarChart,
  TitleComponent,
  TooltipComponent,
  LegendComponent,
  GridComponent
])

// props
const defProps = defineProps({
  title: String,
  wallet: Object,
  report: Object,
  management: Object,
  trades: Object,
  calendars: Object,
  takeProgress: String,
  stopProgress: String
})

// open modal
const openModal = ref(false)

const currencySymbol = ref('R$')

const setCurrencySymbol = computed({
  get () {
    switch (defProps.wallet.currency) {
      case 'USD':
        currencySymbol.value = '$'
        break
      case 'EUR':
        currencySymbol.value = '€'
        break
      case 'BRL':
        currencySymbol.value = 'R$'
        break
    }

    return currencySymbol.value
  }

})

// START TRADE FORM
const tradeForm = useForm({
  wallet_id: defProps.wallet.id,
  management_id: (defProps.management.length >= 1) ? defProps.management[0].id : null,
  assets: 'EUR/USD',
  payout: 82,
  value: 5,
  income: 0,
  operational: 'Retração M5',
  order_type: 'CALL',
  trade_result: '',
  observation: '',
  currency_symbol: setCurrencySymbol
})

const assetsOptions = [
  'EUR/USD', 'EUR/GBP', 'GBP/CHF', 'AUD/CAD', 'AUD/USD', 'JPY/CHF', 'GBP/USD'
]

const operationalOptions = [
  'Retração M5', 'Suporte e Resistência', 'Tendência', 'Vela a Vela', 'Retração M1'
]

const orderTypeOptions = [
  'CALL', 'PUT'
]

// cal income trade
const soros = ref(0)
const sorosIncome = ref(0)
const calcIncome = computed({
  get () {
    tradeForm.income = ((tradeForm.payout / 100) * tradeForm.value).toFixed(2)
    soros.value = (parseFloat(tradeForm.value) + parseFloat(tradeForm.income)).toFixed(2)
    sorosIncome.value = (parseFloat(((tradeForm.payout / 100) * soros.value)) + parseFloat(tradeForm.income)).toFixed(2)
    // sorosIncome.value = (tradeForm.payout / 100) * soros.value
  }
})

// START CALENDAR DATA
const calendarDate = ref(new Date())
const calendarAttributes = []

defProps.calendars.forEach(element => {
  calendarAttributes.push({
    key: element.key,
    highlight: element.highlight,
    dates: element.created_at
  })
})
// END CALENDAR DATA

// Table management pagination config
const managementPagination = {
  sortBy: 'desc',
  descending: false,
  page: 1,
  rowsPerPage: 1
  // rowsNumber: xx if getting data from a server
}

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
  { name: 'result_day', align: 'center', label: 'Resultado', field: 'result_day' }
]

// Table trade pagination config
const tradePagination = {
  sortBy: 'desc',
  descending: false,
  page: 1,
  rowsPerPage: 10
  // rowsNumber: xx if getting data from a server
}

// tables trade columns
const tradeColumns = [
  { name: 'date', align: 'center', label: 'Data', field: 'date' },
  { name: 'assets', align: 'center', label: 'Ativos', field: 'assets' },
  { name: 'payout', align: 'left', label: 'Payout', field: 'payout' },
  { name: 'value', align: 'center', label: 'Investido', field: 'value' },
  { name: 'income', align: 'center', label: 'Renda', field: 'income' },
  { name: 'order_type', align: 'center', label: 'Ordem', field: 'orderType' },
  { name: 'operational', align: 'center', label: 'Operacional', field: 'operational' },
  { name: 'trade_result', align: 'center', label: 'Resultado', field: 'tradeResult' }
]

// pie chart data
const assertivenessOption = ref({
  title: {
    text: 'Assertividade Geral',
    left: 'center'
  },
  tooltip: {
    trigger: 'item',
    formatter: '{a} <br/>{b} : {c} ({d}%)'
  },
  legend: {
    orient: 'vertical',
    left: 'left',
    data: ['WIN', 'LOSS']
  },
  series: [
    {
      name: 'Assertividade Geral',
      type: 'pie',
      radius: '55%',
      center: ['50%', '60%'],
      data: [
        { value: defProps.report.qtd_win, name: 'WIN' },
        { value: defProps.report.qtd_loss, name: 'LOSS' }
      ],
      emphasis: {
        itemStyle: {
          shadowBlur: 10,
          shadowOffsetX: 0,
          shadowColor: 'rgba(0, 0, 0, 0.5)'
        }
      }
    }
  ]
})

// console.log(month)

// bar chart data
const monthOption = reactive({
  title: {
    text: 'Projeção Mensal',
    left: 'center'
  },
  tooltip: {
    trigger: 'item',
    formatter: '{a} <br/>{b} : {c}'
  },
  xAxis: {
    type: 'category',
    data: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez']
  },
  yAxis: {
    type: 'value'
  },
  series: [
    {
      name: 'Banca',
      type: 'bar',
      showBackground: false,
      data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
      emphasis: {
        itemStyle: {
          shadowBlur: 10,
          shadowOffsetX: 0,
          shadowColor: 'rgba(0, 0, 0, 0.5)'
        }
      }
    }
  ]
})

const monthDate = new Date()
const month = monthDate.getMonth()
const arr = reactive([])

const barData = ref(0)
const setDataBar = computed({
  get () {
    return barData.value
  },
  set (data) {
    barData.value = data
  }
})

for (let i = 0; i <= 11; i++) {
  arr[i] = i
  if (month === i) {
    monthOption.series[0].data = arr
  }
}

console.log(monthOption.series[0].data)
console.log(arr)

// console.log(monthOption.series[0].data)
// console.log(monthOption.series[0].data.length)

// console.log(monthOption.series[0].data = [0, 24, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0])

// take profit progress data
const targetTake = computed(() => ((defProps.takeProgress * 100) >= 100))
const takeProgressLabel = computed(() => 'Take profit ' + (defProps.takeProgress * 100).toFixed(2) + '%')

// stop loss progress data
const targetStop = computed(() => ((defProps.stopProgress * 100) >= 100))
const stopProgressLabel = computed(() => 'Stop loss ' + defProps.stopProgress * 100 + '%')

const getTradeResult = computed({
  get () {
    return tradeForm.trade_result
  },
  set (newValue) {
    tradeForm.trade_result = newValue
  }
})

const formattedDate = computed(() => new Date().toLocaleDateString('pt-BR'))

function formattedDateTrades (date) {
  return new Date(date).toLocaleString('pt-BR')
}

function submit () {
  if (tradeForm.trade_result !== 'win') {
    tradeForm.income = 0
  }
  tradeForm.post(route('trade.store'))
}

</script>

<style scoped>
.chart {
  height: 400px;
}
</style>
