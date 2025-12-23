<template>
    <div class="min-h-screen bg-slate-950 text-slate-50">
        <div class="sticky top-0 z-40 border-b border-slate-800/70 bg-slate-950/85 backdrop-blur">
            <div class="mx-auto w-full max-w-6xl px-6 py-4">
                <div class="relative">
                    <label class="sr-only" for="global-search">Buscar</label>
                    <input
                        id="global-search"
                        v-model="searchQuery"
                        type="search"
                        autocomplete="off"
                        placeholder="Buscar reino, filo, ordem, espécie..."
                        class="w-full rounded-xl border border-slate-700/70 bg-slate-900/50 px-4 py-3 text-sm text-slate-100 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400/50"
                        @focus="searchOpen = true"
                        @keydown.escape="searchOpen = false"
                        @keydown.enter.prevent="goToFirstSearchResult"
                    />

                    <div
                        v-if="searchOpen && (searchLoading || searchResults.length || searchQuery.length >= 2)"
                        class="absolute left-0 right-0 mt-2 overflow-hidden rounded-xl border border-slate-700/70 bg-slate-950/95 shadow-lg"
                    >
                        <div v-if="searchLoading" class="px-4 py-3 text-xs font-semibold text-slate-400">
                            Buscando...
                        </div>

                        <button
                            v-for="item in searchResults"
                            :key="item.type + ':' + item.slug"
                            type="button"
                            class="flex w-full items-center justify-between gap-4 px-4 py-3 text-left hover:bg-slate-900/60"
                            @click="navigateTo(item.url)"
                        >
                            <div>
                                <p class="text-sm font-semibold text-slate-100">{{ item.name }}</p>
                                <p class="mt-1 text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">{{ item.type }}</p>
                            </div>
                            <span class="text-xs font-semibold text-emerald-200">Abrir</span>
                        </button>

                        <div v-if="!searchLoading && searchQuery.length >= 2 && !searchResults.length" class="px-4 py-3 text-xs font-semibold text-slate-400">
                            Nenhum resultado.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <header class="relative overflow-hidden">
            <template v-if="isHome">
            <div class="relative h-105">
                <div class="absolute inset-0" :style="heroStyles"></div>
                <div class="absolute inset-0 bg-slate-950/70"></div>
                <div class="relative mx-auto flex h-full w-full max-w-6xl flex-col justify-center px-6 py-14" :style="heroContentStyles">
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-emerald-300/80">Virtual Zoo</p>
                    <h1 class="mt-3 text-3xl font-semibold sm:text-4xl">Exploração taxonômica</h1>
                    <p class="mt-3 max-w-2xl text-sm text-slate-200/80 sm:text-base">
                        Navegue pela hierarquia biológica e acompanhe um painel com os totais do acervo.
                    </p>

                    <div class="mt-8 flex flex-wrap items-center gap-3">
                        <a
                            href="/animais"
                            class="inline-flex items-center rounded-full bg-emerald-500 px-5 py-2 text-sm font-semibold text-slate-950 hover:bg-emerald-400"
                        >
                            Ver animais
                        </a>
                        <a
                            href="/reinos"
                            class="inline-flex items-center rounded-full border border-slate-200/20 bg-slate-900/40 px-5 py-2 text-sm font-semibold text-slate-100 hover:border-emerald-400/50 hover:text-emerald-100"
                        >
                            Ver reinos
                        </a>
                        <a
                            href="/dashboard"
                            class="inline-flex items-center rounded-full border border-slate-200/20 bg-slate-900/40 px-5 py-2 text-sm font-semibold text-slate-100 hover:border-emerald-400/50 hover:text-emerald-100"
                        >
                            Dashboard
                        </a>
                    </div>
                </div>
            </div>
            </template>

            <template v-else>
                <div class="mx-auto w-full max-w-6xl px-6 py-10">
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-400">Virtual Zoo</p>
                    <h1 class="mt-3 text-3xl font-semibold">{{ pageTitle }}</h1>
                    <p v-if="pageSubtitle" class="mt-3 max-w-3xl text-sm text-slate-300/90">
                        {{ pageSubtitle }}
                    </p>
                </div>
            </template>
        </header>

        <main class="mx-auto w-full max-w-6xl space-y-8 px-6 py-10">
            <section v-if="isHome && kingdoms.length" ref="storyEl" class="relative rounded-2xl border border-slate-800/70 bg-slate-900/50">
                <div v-if="prefersReducedMotion" class="p-6">
                    <h2 class="text-sm font-semibold uppercase tracking-[0.35em] text-slate-300">Exploração guiada</h2>
                    <p class="mt-2 text-sm text-slate-300">Conteúdo sem animações (reduzir movimento).</p>

                    <div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                        <a
                            v-for="step in storySteps"
                            :key="step.key"
                            :href="step.href"
                            class="rounded-xl border border-slate-800/70 bg-slate-950/40 p-4 hover:border-emerald-400/60"
                        >
                            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-300">{{ step.levelLabel }}</p>
                            <p class="text-base font-semibold text-slate-50">{{ step.name }}</p>
                            <p class="mt-2 text-sm text-slate-300/80">{{ truncate(step.description, 130) }}</p>
                            <p class="mt-4 text-xs font-semibold text-slate-400">{{ step.statsLabel }}</p>
                        </a>
                    </div>
                </div>

                <div v-else class="relative" :style="storyWrapperStyles">
                    <div class="sticky top-0 h-screen">
                        <div class="absolute inset-0">
                            <div class="absolute inset-0" :style="storyMediaStyles"></div>
                            <video
                                v-if="storyActiveVideoSrc"
                                :key="storyActiveVideoSrc"
                                class="absolute inset-0 h-full w-full object-cover"
                                :style="storyVideoStyles"
                                autoplay
                                muted
                                loop
                                playsinline
                                preload="metadata"
                                @canplay="onStoryVideoCanPlay"
                                @error="disableStoryVideo(storyActiveStep?.video_filename)"
                            >
                                <source :src="storyActiveVideoSrc" type="video/mp4" />
                            </video>
                        </div>
                        <div class="absolute inset-0 bg-slate-950/75"></div>

                        <div class="relative mx-auto flex h-full w-full max-w-6xl flex-col justify-center px-6 py-14">
                            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-emerald-300/80">Exploração guiada</p>
                            <h2 class="mt-3 text-2xl font-semibold sm:text-3xl">Reino a reino · Filo a filo · Ordem a ordem · Espécie a espécie</h2>
                            <p class="mt-3 max-w-2xl text-sm text-slate-200/80 sm:text-base">
                                Role para ver a transição em cada nível da taxonomia.
                            </p>

                            <div class="relative mt-10 h-[56vh]">
                                <div
                                    v-for="(step, index) in storySteps"
                                    :key="step.key"
                                    class="absolute inset-0 flex items-end"
                                    :style="storyStepStyles(index)"
                                >
                                    <div class="w-full rounded-2xl border border-slate-200/10 bg-slate-950/40 p-6 backdrop-blur">
                                        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                                            <div>
                                                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-300">{{ step.levelLabel }}</p>
                                                <h3 class="mt-2 text-2xl font-semibold">{{ step.name }}</h3>
                                                <p v-if="step.breadcrumb" class="mt-2 text-xs font-semibold text-slate-400">
                                                    {{ step.breadcrumb }}
                                                </p>
                                            </div>
                                            <a
                                                :href="step.href"
                                                class="inline-flex items-center rounded-full border border-slate-200/20 bg-slate-900/40 px-5 py-2 text-sm font-semibold text-slate-100 hover:border-emerald-400/50 hover:text-emerald-100"
                                            >
                                                Abrir página
                                            </a>
                                        </div>

                                        <p class="mt-3 max-w-3xl text-sm text-slate-200/80 sm:text-base">
                                            {{ step.description }}
                                        </p>

                                        <p v-if="step.statsLabel" class="mt-5 text-xs font-semibold text-slate-300">{{ step.statsLabel }}</p>
                                        <div v-if="step.metrics && step.metrics.length" class="mt-4 grid gap-3 sm:grid-cols-3">
                                            <MiniMetric v-for="metric in step.metrics" :key="metric.label" :label="metric.label" :value="metric.value" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 flex items-center gap-3 text-xs font-semibold text-slate-300">
                                <span class="rounded-full bg-slate-900/50 px-3 py-1 border border-slate-200/10">Progresso</span>
                                <div class="h-2 w-40 overflow-hidden rounded-full bg-slate-900/70 border border-slate-200/10">
                                    <div class="h-full bg-emerald-400" :style="storyProgressBarStyles"></div>
                                </div>
                                <span class="text-slate-400">{{ storyActiveLabel }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section v-if="isHome" class="rounded-2xl border border-slate-800/70 bg-slate-900/50 p-6">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h2 class="text-sm font-semibold uppercase tracking-[0.35em] text-slate-300">Dashboard</h2>
                        <p class="mt-2 text-sm text-slate-300">Totais calculados a partir da taxonomia carregada.</p>
                    </div>
                    <span class="text-xs font-semibold text-slate-400">Seção atual: {{ sectionLabel }}</span>
                </div>

                <dl class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <MetricCard label="Reinos" :value="totals.kingdoms" />
                    <MetricCard label="Filos" :value="totals.phylums" />
                    <MetricCard label="Classes" :value="totals.classes" />
                    <MetricCard label="Ordens" :value="totals.orders" />
                    <MetricCard label="Famílias" :value="totals.families" />
                    <MetricCard label="Gêneros" :value="totals.genera" />
                    <MetricCard label="Espécies" :value="totals.species" />
                    <MetricCard label="Animais" :value="totals.animals" />
                </dl>

                <p v-if="totals.kingdoms === 0" class="mt-6 text-sm text-amber-200/90">
                    Nenhum dado de taxonomia encontrado. Rode <span class="font-semibold">php artisan db:seed</span> para popular dados de exemplo.
                </p>
            </section>

            <section v-if="isHome && kingdoms.length" class="rounded-2xl border border-slate-800/70 bg-slate-900/50 p-6">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h2 class="text-sm font-semibold uppercase tracking-[0.35em] text-slate-300">Reinos</h2>
                        <p class="mt-2 text-sm text-slate-300">Clique em um reino para explorar abaixo.</p>
                    </div>
                    <a href="/reinos" class="text-sm font-semibold text-emerald-200 hover:text-emerald-100">Ver página</a>
                </div>

                <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    <button
                        v-for="kingdom in kingdoms"
                        :key="kingdom.slug"
                        type="button"
                        class="group text-left rounded-xl border border-slate-800/70 bg-slate-950/40 p-4 hover:border-emerald-400/60 transition-all duration-700"
                        :class="cardRevealClass(kingdom.slug)"
                        :data-reveal-key="kingdom.slug"
                        @click="selectKingdom(kingdom.slug)"
                    >
                        <p class="text-base font-semibold text-slate-50">{{ kingdom.name }}</p>
                        <p v-if="kingdom.scientific_name" class="mt-1 text-xs text-slate-300">{{ kingdom.scientific_name }}</p>
                        <p v-if="kingdom.description" class="mt-3 text-sm text-slate-300/80">
                            {{ truncate(kingdom.description, 120) }}
                        </p>
                        <div class="mt-4 flex items-center justify-between gap-3">
                            <p class="text-sm font-semibold text-emerald-200 group-hover:text-emerald-100">Selecionar</p>
                            <a
                                :href="`/reinos/${kingdom.slug}`"
                                class="text-sm font-semibold text-slate-300 hover:text-slate-100"
                                @click.stop
                            >
                                Abrir página
                            </a>
                        </div>
                    </button>
                </div>
            </section>

            <section
                v-if="selectedKingdom"
                id="explorar"
                class="rounded-2xl border border-slate-800/70 bg-slate-900/50 p-6"
            >
                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-300">Explorando</p>
                        <h2 class="mt-2 text-2xl font-semibold">{{ selectedKingdom.name }}</h2>
                        <p v-if="selectedKingdom.description" class="mt-2 text-sm text-slate-300">
                            {{ selectedKingdom.description }}
                        </p>
                    </div>
                    <button
                        type="button"
                        class="inline-flex items-center rounded-full border border-slate-200/20 bg-slate-900/40 px-5 py-2 text-sm font-semibold text-slate-100 hover:border-emerald-400/50 hover:text-emerald-100"
                        @click="clearSelection"
                    >
                        Voltar
                    </button>
                </div>

                <div class="mt-6">
                    <h3 class="text-sm font-semibold uppercase tracking-[0.35em] text-slate-300">Filos</h3>
                    <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                        <div
                            v-for="phylum in selectedKingdom.phylums || []"
                            :key="phylum.slug"
                            class="rounded-xl border border-slate-800/70 bg-slate-950/40 p-4 transition-all duration-700"
                            :class="cardRevealClass(`phylum:${phylum.slug}`)"
                            :data-reveal-key="`phylum:${phylum.slug}`"
                        >
                            <p class="text-base font-semibold text-slate-50">{{ phylum.name }}</p>
                            <p v-if="phylum.scientific_name" class="mt-1 text-xs text-slate-300">{{ phylum.scientific_name }}</p>
                            <p v-if="phylum.description" class="mt-3 text-sm text-slate-300/80">
                                {{ truncate(phylum.description, 130) }}
                            </p>
                            <div class="mt-4 flex items-center justify-between gap-3">
                                <a
                                    :href="`/filos/${phylum.slug}`"
                                    class="text-sm font-semibold text-emerald-200 hover:text-emerald-100"
                                >
                                    Abrir
                                </a>
                                <span class="text-xs font-semibold text-slate-400">{{ (phylum.classes || []).length }} classes</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section v-if="!isHome && sectionLabel === 'species' && speciesFocus" class="rounded-2xl border border-slate-800/70 bg-slate-900/50 p-6">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-400">Espécie</p>
                        <h2 class="mt-2 text-2xl font-semibold">{{ speciesFocus.name }}</h2>
                        <p v-if="speciesFocus.scientific_name" class="mt-2 text-sm text-slate-300">
                            {{ speciesFocus.scientific_name }}
                        </p>
                    </div>
                    <a
                        :href="`/especies/${speciesFocus.slug}`"
                        class="inline-flex items-center rounded-full border border-slate-200/20 bg-slate-900/40 px-5 py-2 text-sm font-semibold text-slate-100 hover:border-emerald-400/50 hover:text-emerald-100"
                    >
                        Link permanente
                    </a>
                </div>

                <p v-if="speciesFocus.description" class="mt-4 max-w-4xl text-sm text-slate-200/80 sm:text-base">
                    {{ speciesFocus.description }}
                </p>

                <div v-if="speciesBreadcrumbParts.length" class="mt-6 flex flex-wrap gap-2">
                    <a
                        v-for="crumb in speciesBreadcrumbParts"
                        :key="crumb.url"
                        :href="crumb.url"
                        class="rounded-full border border-slate-200/10 bg-slate-950/30 px-3 py-1 text-xs font-semibold text-slate-300 hover:border-emerald-400/40 hover:text-emerald-100"
                    >
                        {{ crumb.label }}
                    </a>
                </div>
            </section>

            <section v-if="featuredCount" class="rounded-2xl border border-slate-800/70 bg-slate-900/50 p-6">
                <div class="flex items-end justify-between gap-4">
                    <h2 class="text-sm font-semibold uppercase tracking-[0.35em] text-slate-300">Animais em destaque</h2>
                    <a href="/animais" class="text-sm font-semibold text-emerald-200 hover:text-emerald-100">Ver todos</a>
                </div>
                <ul class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    <li
                        v-for="animal in featuredAnimals"
                        :key="animal.slug"
                        class="rounded-xl border border-slate-800/70 bg-slate-950/40 p-4"
                    >
                        <p class="text-base font-semibold text-slate-50">{{ animal.name }}</p>
                        <p v-if="animal.scientific_name" class="mt-1 text-xs text-slate-300">{{ animal.scientific_name }}</p>
                        <a
                            v-if="animal.slug"
                            :href="`/animais/${animal.slug}`"
                            class="mt-3 inline-block text-sm font-semibold text-emerald-200 hover:text-emerald-100"
                        >
                            Ver detalhes
                        </a>
                    </li>
                </ul>
            </section>
        </main>
    </div>
</template>

<script setup>
import { computed, nextTick, onMounted, onUnmounted, ref, watch } from 'vue';

const initialPayload = window.__VIRTUAL_ZOO__ ?? {};

const assetBaseUrl = computed(() => initialPayload.assetBaseUrl ?? '/');

function toAbsoluteUrl(path) {
    // Usa a URL atual como base para suportar instalação em subpasta (WAMP).
    // Ex.: /projects/virtualzoo/public/ + videos/x.mp4 => /projects/virtualzoo/public/videos/x.mp4
    const normalized = String(path || '').replace(/^\//, '');
    return new URL(normalized, window.location.href).toString();
}

const taxonomy = computed(() => initialPayload.taxonomy ?? []);
const featuredAnimals = computed(() => (initialPayload.featuredAnimals ?? []).filter((a) => a && a.slug));
const pageContext = computed(() => initialPayload.pageContext ?? {});

const kingdoms = computed(() => taxonomy.value);
const featuredCount = computed(() => featuredAnimals.value.length);
const sectionLabel = computed(() => pageContext.value.section ?? 'home');
const isHome = computed(() => sectionLabel.value === 'home');

const pageTitle = computed(() => {
    const focus = pageContext.value.focus;
    if (focus?.name) {
        return focus.name;
    }

    const section = sectionLabel.value;
    const titles = {
        kingdoms: 'Reinos',
        phylums: 'Filos',
        classes: 'Classes',
        orders: 'Ordens',
        families: 'Famílias',
        genera: 'Gêneros',
        species: 'Espécies',
        animals: 'Animais',
    };

    return titles[section] ?? 'Virtual Zoo';
});

const pageSubtitle = computed(() => {
    if (sectionLabel.value === 'species' && pageContext.value.focus?.type === 'Species') {
        return 'Detalhes da espécie e caminhos na taxonomia.';
    }
    return '';
});

const speciesFocus = computed(() => {
    const focus = pageContext.value.focus;
    if (!focus || focus.type !== 'Species') {
        return null;
    }
    return focus.data ?? null;
});

const speciesBreadcrumbParts = computed(() => {
    const data = speciesFocus.value;
    const c = data?.classification ?? {};
    const parts = [];

    if (c.kingdom?.slug) parts.push({ label: `Reino: ${c.kingdom.name}`, url: `/reinos/${c.kingdom.slug}` });
    if (c.phylum?.slug) parts.push({ label: `Filo: ${c.phylum.name}`, url: `/filos/${c.phylum.slug}` });
    if (c.class?.slug) parts.push({ label: `Classe: ${c.class.name}`, url: `/classes/${c.class.slug}` });
    if (c.order?.slug) parts.push({ label: `Ordem: ${c.order.name}`, url: `/ordens/${c.order.slug}` });
    if (c.family?.slug) parts.push({ label: `Família: ${c.family.name}`, url: `/familias/${c.family.slug}` });
    if (c.genus?.slug) parts.push({ label: `Gênero: ${c.genus.name}`, url: `/generos/${c.genus.slug}` });

    return parts;
});

// Search global (autocomplete)
const searchQuery = ref('');
const searchResults = ref([]);
const searchLoading = ref(false);
const searchOpen = ref(false);
let searchTimer = null;

function navigateTo(url) {
    if (!url) {
        return;
    }
    window.location.href = url;
}

function goToFirstSearchResult() {
    const first = searchResults.value[0];
    if (first?.url) {
        navigateTo(first.url);
        return;
    }
    searchOpen.value = false;
}

async function fetchSearchResults(query) {
    const base = assetBaseUrl.value ?? '/';
    const url = new URL('dados/busca', base);
    url.searchParams.set('q', query);

    searchLoading.value = true;
    try {
        const res = await fetch(url.toString(), { headers: { Accept: 'application/json' } });
        if (!res.ok) {
            searchResults.value = [];
            return;
        }
        const json = await res.json();
        searchResults.value = Array.isArray(json) ? json : [];
    } catch (e) {
        searchResults.value = [];
    } finally {
        searchLoading.value = false;
    }
}

watch(
    () => searchQuery.value,
    (val) => {
        const q = (val ?? '').trim();

        if (searchTimer) {
            clearTimeout(searchTimer);
        }

        if (q.length < 2) {
            searchResults.value = [];
            searchLoading.value = false;
            return;
        }

        searchTimer = setTimeout(() => {
            fetchSearchResults(q);
        }, 180);
    }
);

const selectedKingdomSlug = ref(null);
const selectedKingdom = computed(() => {
    if (!selectedKingdomSlug.value) {
        return null;
    }
    return (taxonomy.value ?? []).find((k) => k?.slug === selectedKingdomSlug.value) ?? null;
});

const scrollY = ref(0);
const prefersReducedMotion = ref(false);

const revealedKeys = ref(new Set());
let revealObserver = null;

const heroImageUrl = computed(() => {
    const kingdomWithHero = taxonomy.value.find((k) => k && k.hero_image_url);
    return kingdomWithHero?.hero_image_url ?? null;
});

const heroStyles = computed(() => {
    const offset = prefersReducedMotion.value ? 0 : Math.max(-160, scrollY.value * -0.22);

    const backgroundImage = heroImageUrl.value
        ? `linear-gradient(135deg, rgba(2,6,23,0.92), rgba(2,6,23,0.55)), url('${heroImageUrl.value}')`
        : 'linear-gradient(135deg, rgba(2,6,23,0.98), rgba(2,6,23,0.70))';

    return {
        transform: `translate3d(0, ${offset}px, 0)`,
        backgroundImage,
        backgroundSize: 'cover',
        backgroundPosition: 'center',
        willChange: 'transform',
    };
});

const heroContentStyles = computed(() => {
    const offset = prefersReducedMotion.value ? 0 : Math.min(48, scrollY.value * 0.12);
    return {
        transform: `translate3d(0, ${offset}px, 0)`,
        willChange: 'transform',
    };
});

const storyEl = ref(null);
const storyTop = ref(0);
const storyHeight = ref(1);

const storyVideoIsReady = ref(false);

const storySteps = computed(() => {
    const steps = [];

    function buildStep({
        key,
        levelLabel,
        name,
        description,
        href,
        media_url,
        video_filename,
        breadcrumb,
        metrics,
        statsLabel,
    }) {
        return {
            key,
            levelLabel,
            name,
            description: description ?? '',
            href,
            media_url: media_url ?? null,
            video_filename: video_filename ?? null,
            breadcrumb: breadcrumb ?? '',
            metrics: Array.isArray(metrics) ? metrics : [],
            statsLabel: statsLabel ?? '',
        };
    }

    function countFromOrders(orders) {
        let familiesCount = 0;
        let speciesCount = 0;
        let animalsCount = 0;

        (orders ?? []).forEach((order) => {
            const families = order?.families ?? [];
            familiesCount += families.length;

            families.forEach((family) => {
                (family?.genera ?? []).forEach((genus) => {
                    (genus?.species ?? []).forEach((specie) => {
                        speciesCount += 1;
                        animalsCount += (specie?.animals ?? []).length;
                    });
                });
            });
        });

        return { familiesCount, speciesCount, animalsCount };
    }

    function countFromPhylum(phylum) {
        const classes = phylum?.classes ?? [];
        let ordersCount = 0;
        const orders = [];

        classes.forEach((clazz) => {
            const clazzOrders = clazz?.orders ?? [];
            ordersCount += clazzOrders.length;
            orders.push(...clazzOrders);
        });

        const { familiesCount, speciesCount, animalsCount } = countFromOrders(orders);
        return { classesCount: classes.length, ordersCount, familiesCount, speciesCount, animalsCount, orders };
    }

    function countFromKingdom(kingdom) {
        const phylums = kingdom?.phylums ?? [];
        let ordersCount = 0;
        let speciesCount = 0;
        let animalsCount = 0;

        phylums.forEach((phylum) => {
            const counts = countFromPhylum(phylum);
            ordersCount += counts.ordersCount;
            speciesCount += counts.speciesCount;
            animalsCount += counts.animalsCount;
        });

        return { phylumsCount: phylums.length, ordersCount, speciesCount, animalsCount };
    }

    function speciesMediaUrl(specie, fallbackUrl) {
        const animals = specie?.animals ?? [];
        const withImage = animals.find((a) => a?.featured_image_url);
        return withImage?.featured_image_url ?? fallbackUrl ?? null;
    }

    (taxonomy.value ?? []).forEach((kingdom) => {
        if (!kingdom?.slug) {
            return;
        }

        const kingdomCounts = countFromKingdom(kingdom);
        steps.push(
            buildStep({
                key: `kingdom:${kingdom.slug}`,
                levelLabel: 'Reino',
                name: kingdom.name,
                description: kingdom.description,
                href: `/reinos/${kingdom.slug}`,
                media_url: kingdom.hero_image_url,
                video_filename: kingdom.hero_video_filename,
                breadcrumb: '',
                metrics: [
                    { label: 'Filos', value: kingdomCounts.phylumsCount },
                    { label: 'Ordens', value: kingdomCounts.ordersCount },
                    { label: 'Animais', value: kingdomCounts.animalsCount },
                ],
                statsLabel: `${kingdomCounts.phylumsCount} filos · ${kingdomCounts.ordersCount} ordens · ${kingdomCounts.animalsCount} animais`,
            })
        );

        (kingdom.phylums ?? []).forEach((phylum) => {
            if (!phylum?.slug) {
                return;
            }

            const phylumCounts = countFromPhylum(phylum);
            steps.push(
                buildStep({
                    key: `phylum:${phylum.slug}`,
                    levelLabel: 'Filo',
                    name: phylum.name,
                    description: phylum.description,
                    href: `/filos/${phylum.slug}`,
                    media_url: kingdom.hero_image_url,
                    video_filename: phylum.hero_video_filename ?? kingdom.hero_video_filename,
                    breadcrumb: kingdom.name,
                    metrics: [
                        { label: 'Classes', value: phylumCounts.classesCount },
                        { label: 'Ordens', value: phylumCounts.ordersCount },
                        { label: 'Animais', value: phylumCounts.animalsCount },
                    ],
                    statsLabel: `${phylumCounts.classesCount} classes · ${phylumCounts.ordersCount} ordens · ${phylumCounts.animalsCount} animais`,
                })
            );

            // Ordem a ordem
            (phylumCounts.orders ?? []).forEach((order) => {
                if (!order?.slug) {
                    return;
                }

                const { familiesCount, speciesCount, animalsCount } = countFromOrders([order]);

                steps.push(
                    buildStep({
                        key: `order:${order.slug}`,
                        levelLabel: 'Ordem',
                        name: order.name,
                        description: order.description,
                        href: `/ordens/${order.slug}`,
                        media_url: kingdom.hero_image_url,
                        video_filename: order.hero_video_filename ?? phylum.hero_video_filename ?? kingdom.hero_video_filename,
                        breadcrumb: `${kingdom.name} · ${phylum.name}`,
                        metrics: [
                            { label: 'Famílias', value: familiesCount },
                            { label: 'Espécies', value: speciesCount },
                            { label: 'Animais', value: animalsCount },
                        ],
                        statsLabel: `${familiesCount} famílias · ${speciesCount} espécies · ${animalsCount} animais`,
                    })
                );

                // Espécie a espécie
                (order?.families ?? []).forEach((family) => {
                    (family?.genera ?? []).forEach((genus) => {
                        (genus?.species ?? []).forEach((specie) => {
                            if (!specie?.slug) {
                                return;
                            }

                            const animals = specie?.animals ?? [];
                            const animalsCountForSpecies = animals.length;

                            steps.push(
                                buildStep({
                                    key: `species:${specie.slug}`,
                                    levelLabel: 'Espécie',
                                    name: specie.name,
                                    description: specie.description,
                                    href: `/especies/${specie.slug}`,
                                    media_url: speciesMediaUrl(specie, kingdom.hero_image_url),
                                    video_filename:
                                        specie.hero_video_filename ??
                                        order.hero_video_filename ??
                                        phylum.hero_video_filename ??
                                        kingdom.hero_video_filename,
                                    breadcrumb: `${kingdom.name} · ${phylum.name} · ${order.name}`,
                                    metrics: [{ label: 'Animais', value: animalsCountForSpecies }],
                                    statsLabel: `${animalsCountForSpecies} animais`,
                                })
                            );
                        });
                    });
                });
            });
        });
    });

    return steps;
});

const storyTotalVh = computed(() => {
    // Mantém ~2 telas de rolagem e evita “vazio” enorme.
    // Mesmo com muitos passos, o índice avança mais rápido ao rolar.
    const minVh = 240;
    const maxVh = 420;
    const perStepVh = 4;
    const cappedSteps = Math.min(40, storySteps.value.length);
    return Math.min(maxVh, Math.max(minVh, minVh + cappedSteps * perStepVh));
});

const storyWrapperStyles = computed(() => ({
    height: `${storyTotalVh.value}vh`,
}));

const storyProgress = computed(() => {
    if (!storyTop.value || !storyHeight.value) {
        return 0;
    }

    const raw = (scrollY.value - storyTop.value) / storyHeight.value;
    return Math.min(1, Math.max(0, raw));
});

const storyActiveIndex = computed(() => {
    const count = Math.max(1, storySteps.value.length);
    const idx = Math.floor(storyProgress.value * count);
    return Math.min(count - 1, Math.max(0, idx));
});

const storyActiveStep = computed(() => storySteps.value[storyActiveIndex.value] ?? null);
const storyActiveLabel = computed(() => storyActiveStep.value?.name ?? '');

const storyVideoEnabled = ref(true);
const missingStoryVideos = ref(new Set());
const videoAttemptByFilename = ref(new Map());

const storyActiveVideoSrc = computed(() => {
    if (!storyVideoEnabled.value) {
        return null;
    }
    const filename = storyActiveStep.value?.video_filename;
    if (!filename) {
        return null;
    }

    if (missingStoryVideos.value.has(filename)) {
        return null;
    }

    const attempt = videoAttemptByFilename.value.get(filename) ?? 0;

    // Tentativa 0: usa como veio do banco.
    // Tentativa 1: tenta variação comum (ex.: arquivo salvo como "animalia.mp4.mp4").
    if (attempt === 0) {
        return toAbsoluteUrl(`videos/${filename}`);
    }

    if (attempt === 1) {
        const alt = filename.endsWith('.mp4') ? `${filename}.mp4` : `${filename}.mp4`;
        return toAbsoluteUrl(`videos/${alt}`);
    }

    return null;
});

const storyMediaStyles = computed(() => {
    const offset = Math.max(-220, scrollY.value * -0.18);

    const imageUrl = storyActiveStep.value?.media_url;
    const backgroundImage = imageUrl
        ? `linear-gradient(135deg, rgba(2,6,23,0.96), rgba(2,6,23,0.62)), url('${imageUrl}')`
        : 'linear-gradient(135deg, rgba(2,6,23,0.98), rgba(2,6,23,0.70))';

    return {
        transform: `translate3d(0, ${offset}px, 0) scale(1.06)`,
        backgroundImage,
        backgroundSize: 'cover',
        backgroundPosition: 'center',
        willChange: 'transform',
    };
});

const storyVideoStyles = computed(() => {
    const offset = Math.max(-220, scrollY.value * -0.18);
    return {
        transform: `translate3d(0, ${offset}px, 0) scale(1.06)`,
        willChange: 'transform',
        filter: 'saturate(1.05)',
        opacity: storyVideoIsReady.value ? 1 : 0,
        transition: 'opacity 450ms ease',
    };
});

function disableStoryVideo(filename) {
    if (!filename) {
        // Se não conseguimos identificar qual arquivo falhou, desliga o vídeo geral.
        storyVideoEnabled.value = false;
        return;
    }

    const current = videoAttemptByFilename.value.get(filename) ?? 0;
    if (current === 0) {
        videoAttemptByFilename.value.set(filename, 1);
        return;
    }

    missingStoryVideos.value.add(filename);
}

function onStoryVideoCanPlay() {
    storyVideoIsReady.value = true;
}

const storyProgressBarStyles = computed(() => ({
    width: `${Math.round(storyProgress.value * 100)}%`,
}));

function storyStepStyles(index) {
    const count = Math.max(1, storySteps.value.length);
    const local = Math.min(1, Math.max(0, storyProgress.value * count - index));

    // local: 0..1 (entra). Mantém um pouco depois de entrar.
    const enterOpacity = local < 0.1 ? local / 0.1 : 1;
    const exit = Math.min(1, Math.max(0, local - 0.85) / 0.15);
    const finalOpacity = enterOpacity * (1 - exit);

    const translate = (1 - local) * 26 + exit * -18;

    return {
        opacity: finalOpacity,
        transform: `translate3d(0, ${translate}px, 0)`,
        transition: 'opacity 450ms ease, transform 650ms cubic-bezier(0.2, 0.8, 0.2, 1)',
        pointerEvents: index === storyActiveIndex.value ? 'auto' : 'none',
    };
}

const totals = computed(() => {
    const counters = {
        kingdoms: 0,
        phylums: 0,
        classes: 0,
        orders: 0,
        families: 0,
        genera: 0,
        species: 0,
        animals: 0,
    };

    const kingdomsList = taxonomy.value ?? [];
    counters.kingdoms = kingdomsList.length;

    kingdomsList.forEach((kingdom) => {
        const phylums = kingdom?.phylums ?? [];
        counters.phylums += phylums.length;

        phylums.forEach((phylum) => {
            const classes = phylum?.classes ?? [];
            counters.classes += classes.length;

            classes.forEach((clazz) => {
                const orders = clazz?.orders ?? [];
                counters.orders += orders.length;

                orders.forEach((order) => {
                    const families = order?.families ?? [];
                    counters.families += families.length;

                    families.forEach((family) => {
                        const genera = family?.genera ?? [];
                        counters.genera += genera.length;

                        genera.forEach((genus) => {
                            const species = genus?.species ?? [];
                            counters.species += species.length;

                            species.forEach((specie) => {
                                const animals = specie?.animals ?? [];
                                counters.animals += animals.length;
                            });
                        });
                    });
                });
            });
        });
    });

    return counters;
});

function truncate(text, length) {
    if (!text || typeof text !== 'string') {
        return '';
    }
    if (text.length <= length) {
        return text;
    }
    return `${text.slice(0, length - 3)}...`;
}

function handleScroll() {
    scrollY.value = window.scrollY || window.pageYOffset || 0;
}

function recalcStoryMetrics() {
    if (!storyEl.value) {
        return;
    }

    const rect = storyEl.value.getBoundingClientRect();
    storyTop.value = (window.scrollY || window.pageYOffset || 0) + rect.top;
    storyHeight.value = Math.max(1, storyEl.value.offsetHeight - window.innerHeight);
}

function cardRevealClass(key) {
    const visible = revealedKeys.value.has(key);
    if (prefersReducedMotion.value) {
        return 'opacity-100 translate-y-0';
    }
    return visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6';
}

async function selectKingdom(slug) {
    selectedKingdomSlug.value = slug;
    await nextTick();
    ensureRevealObserver();
    const section = document.getElementById('explorar');
    if (section) {
        section.scrollIntoView({ behavior: prefersReducedMotion.value ? 'auto' : 'smooth', block: 'start' });
    }
}

function clearSelection() {
    selectedKingdomSlug.value = null;
}

function ensureRevealObserver() {
    if (revealObserver) {
        return;
    }

    if (prefersReducedMotion.value) {
        return;
    }

    revealObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }
                const key = entry.target?.getAttribute('data-reveal-key');
                if (key) {
                    revealedKeys.value.add(key);
                }
                revealObserver?.unobserve(entry.target);
            });
        },
        { root: null, threshold: 0.12 }
    );

    document.querySelectorAll('[data-reveal-key]').forEach((el) => revealObserver.observe(el));
}

onMounted(() => {
    const mediaQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
    prefersReducedMotion.value = mediaQuery.matches;

    handleScroll();
    window.addEventListener('scroll', handleScroll, { passive: true });
    window.addEventListener('resize', recalcStoryMetrics, { passive: true });
    recalcStoryMetrics();

    // Primeira renderização: já registra as animações de cards.
    ensureRevealObserver();
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
    window.removeEventListener('resize', recalcStoryMetrics);
    revealObserver?.disconnect();
    revealObserver = null;
});

watch(
    () => storyActiveVideoSrc.value,
    async () => {
        storyVideoIsReady.value = false;
        await nextTick();
    }
);

const MetricCard = {
    props: {
        label: { type: String, required: true },
        value: { type: Number, required: true },
    },
    template: `
        <div class="rounded-xl border border-slate-800/70 bg-slate-950/40 p-4">
            <dt class="text-xs font-semibold text-slate-300">{{ label }}</dt>
            <dd class="mt-1 text-2xl font-semibold text-emerald-200">{{ value }}</dd>
        </div>
    `,
};

const MiniMetric = {
    props: {
        label: { type: String, required: true },
        value: { type: Number, required: true },
    },
    template: `
        <div class="rounded-xl border border-slate-200/10 bg-slate-950/30 p-4">
            <dt class="text-xs font-semibold text-slate-300">{{ label }}</dt>
            <dd class="mt-1 text-xl font-semibold text-emerald-200">{{ value }}</dd>
        </div>
    `,
};
</script>
