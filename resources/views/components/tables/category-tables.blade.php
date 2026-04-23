<div x-data="{
    categories: [{
            id: 1,
            name: 'Shopping',
            monthly_budget: 'IDR 500.000',
            expense_this_month: 'IDR 0',
            usage: '0%',
        },
        {
            id: 2,
            name: 'Transportation',
            monthly_budget: 'IDR 500.000',
            expense_this_month: 'IDR 0',
            usage: '0%',
        },
        {
            id: 3,
            name: 'Daily Food',
            monthly_budget: 'IDR 500.000',
            expense_this_month: 'IDR 0',
            usage: '0%',
        },
        {
            id: 4,
            name: 'Dining Out',
            monthly_budget: 'IDR 500.000',
            expense_this_month: 'IDR 0',
            usage: '0%',
        },
        {
            id: 5,
            name: 'Subscription',
            monthly_budget: 'IDR 500.000',
            expense_this_month: 'IDR 0',
            usage: '0%',
        },
        {
            id: 6,
            name: 'Subscription',
            monthly_budget: 'IDR 500.000',
            expense_this_month: 'IDR 0',
            usage: '0%',
        },
    ],
    {{-- categories: [], --}}
    itemsPerPage: 5,
    currentPage: 1,
    dropdownOpen: null,
    get totalPages() {
        return this.totalEntries === 0 ? 1 : Math.ceil(this.totalEntries / this.itemsPerPage);
    },
    get paginatedcategories() {
        const start = (this.currentPage - 1) * this.itemsPerPage;
        const end = start + this.itemsPerPage;
        return this.categories.slice(start, end);
    },
    get displayedPages() {
        const range = [];
        for (let i = 1; i <= this.totalPages; i++) {
            if (
                i === 1 ||
                i === this.totalPages ||
                (i >= this.currentPage - 1 && i <= this.currentPage + 1)
            ) {
                range.push(i);
            } else if (range[range.length - 1] !== '...') {
                range.push('...');
            }
        }
        return range;
    },
    prevPage() {
        if (this.currentPage > 1) {
            this.currentPage--;
        }
    },
    nextPage() {
        if (this.currentPage < this.totalPages) {
            this.currentPage++;
        }
    },
    goToPage(page) {
        if (typeof page === 'number' && page >= 1 && page <= this.totalPages) {
            this.currentPage = page;
        }
    },
    getStatusClass(status) {
        const classes = {
            'Success': 'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500',
            'Pending': 'bg-yellow-50 text-yellow-600 dark:bg-yellow-500/15 dark:text-orange-400',
            'Failed': 'bg-red-50 text-red-600 dark:bg-red-500/15 dark:text-red-500',
        };
        return classes[status] || '';
    },
    toggleDropdown(id) {
        this.dropdownOpen = this.dropdownOpen === id ? null : id;
    },
    get totalEntries() {
        return this.categories.length;
    },
    get start() {
        return this.totalEntries === 0 ? 0 : (this.currentPage - 1) * this.itemsPerPage + 1;
    },
    get end() {
        const end = this.currentPage * this.itemsPerPage;
        return end > this.totalEntries ? this.totalEntries : end;
    },
    price: '',
    formatRupiah(value) {
        let number = value.replace(/[^,\d]/g, '').toString();
        let split = number.split(',');
        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    }
}">
    <div class="rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">
        <!-- Header -->
        <div class="flex flex-col gap-2 px-5 mb-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <div class="flex items-center gap-3">
                <span class="text-gray-500 dark:text-gray-400 ">Show</span>
                <div class="relative">
                    <select x-model.number="itemsPerPage" @change="currentPage = 1"
                        class="w-full py-2 pl-3 pr-8 appearance-none text-sm text-gray-800 bg-transparent border border-gray-300 rounded-lg dark:bg-dark-900 h-9 bg-none shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select>
                    <span
                        class="absolute z-30 text-gray-500 -translate-y-1/2 pointer-events-none right-2 top-1/2 dark:text-gray-400">
                        <svg class="stroke-current" width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.8335 5.9165L8.00016 10.0832L12.1668 5.9165" stroke="" stroke-width="1.2"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </div>
                <span class="text-gray-500 dark:text-gray-400 ">categories</span>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <form>
                    <div class="relative">
                        <button type="button" class="absolute -translate-y-1/2 left-4 top-1/2">
                            <svg class="fill-gray-500 dark:fill-gray-400" width="20" height="20"
                                viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M3.04199 9.37381C3.04199 5.87712 5.87735 3.04218 9.37533 3.04218C12.8733 3.04218 15.7087 5.87712 15.7087 9.37381C15.7087 12.8705 12.8733 15.7055 9.37533 15.7055C5.87735 15.7055 3.04199 12.8705 3.04199 9.37381ZM9.37533 1.54218C5.04926 1.54218 1.54199 5.04835 1.54199 9.37381C1.54199 13.6993 5.04926 17.2055 9.37533 17.2055C11.2676 17.2055 13.0032 16.5346 14.3572 15.4178L17.1773 18.2381C17.4702 18.531 17.945 18.5311 18.2379 18.2382C18.5308 17.9453 18.5309 17.4704 18.238 17.1775L15.4182 14.3575C16.5367 13.0035 17.2087 11.2671 17.2087 9.37381C17.2087 5.04835 13.7014 1.54218 9.37533 1.54218Z"
                                    fill="" />
                            </svg>
                        </button>
                        <input type="text" placeholder="Search..."
                            class="h-[42px] w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-[42px] pr-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-blue-800 xl:w-[300px]" />
                    </div>
                </form>
                <button @click="$dispatch('open-add-category-modal')"
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-main px-4 py-3 text-theme-sm font-medium text-white shadow-theme-xs hover:bg-main-hover hover:text-white/90 dark:border-gray-700 dark:bg-main dark:text-white dark:hover:bg-main-hover dark:hover:text-white/90">
                    Add Category
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-hidden">
            <div class="max-w-full px-5 overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-gray-200 border-y dark:border-gray-700">
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-900 dark:text-white text-start text-theme-sm">
                                No</th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-900 dark:text-white text-start text-theme-sm">
                                Name</th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-900 dark:text-white text-start text-theme-sm">
                                Monthly Budget</th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-900 dark:text-white text-start text-theme-sm">
                                Expense This Month</th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-900 dark:text-white text-start text-theme-sm">
                                Usage</th>
                            <th scope="col"
                                class="px-4 py-3 font-normal text-gray-900 dark:text-white text-start text-theme-sm">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <template x-for="(category, index) in paginatedcategories" :key="category.id">
                            <tr>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400"
                                        x-text="(currentPage - 1) * itemsPerPage + index + 1"></div>
                                </td>
                                <td class="py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        {{-- <div class="shrink-0 w-8 h-8"> --}}
                                        {{-- <img class="w-8 h-8 rounded-full" :src="category.image" alt=""> --}}
                                        {{-- </div> --}}
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white"
                                                x-text="category.name"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white" x-text="category.monthly_budget">
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white"
                                        x-text="category.expense_this_month"></div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white" x-text="category.usage"></div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        <div class="flex items-center w-full gap-2">
                                            <button @click="deleteRow(category.id)"
                                                class="text-gray-500 hover:text-error-500 dark:text-gray-400 dark:hover:text-error-500">
                                                <svg class="fill-current" width="21" height="21"
                                                    viewBox="0 0 21 21" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M7.04142 4.29199C7.04142 3.04935 8.04878 2.04199 9.29142 2.04199H11.7081C12.9507 2.04199 13.9581 3.04935 13.9581 4.29199V4.54199H16.1252H17.166C17.5802 4.54199 17.916 4.87778 17.916 5.29199C17.916 5.70621 17.5802 6.04199 17.166 6.04199H16.8752V8.74687V13.7469V16.7087C16.8752 17.9513 15.8678 18.9587 14.6252 18.9587H6.37516C5.13252 18.9587 4.12516 17.9513 4.12516 16.7087V13.7469V8.74687V6.04199H3.8335C3.41928 6.04199 3.0835 5.70621 3.0835 5.29199C3.0835 4.87778 3.41928 4.54199 3.8335 4.54199H4.87516H7.04142V4.29199ZM15.3752 13.7469V8.74687V6.04199H13.9581H13.2081H7.79142H7.04142H5.62516V8.74687V13.7469V16.7087C5.62516 17.1229 5.96095 17.4587 6.37516 17.4587H14.6252C15.0394 17.4587 15.3752 17.1229 15.3752 16.7087V13.7469ZM8.54142 4.54199H12.4581V4.29199C12.4581 3.87778 12.1223 3.54199 11.7081 3.54199H9.29142C8.87721 3.54199 8.54142 3.87778 8.54142 4.29199V4.54199ZM8.8335 8.50033C9.24771 8.50033 9.5835 8.83611 9.5835 9.25033V14.2503C9.5835 14.6645 9.24771 15.0003 8.8335 15.0003C8.41928 15.0003 8.0835 14.6645 8.0835 14.2503V9.25033C8.0835 8.83611 8.41928 8.50033 8.8335 8.50033ZM12.9168 9.25033C12.9168 8.83611 12.581 8.50033 12.1668 8.50033C11.7526 8.50033 11.4168 8.83611 11.4168 9.25033V14.2503C11.4168 14.6645 11.7526 15.0003 12.1668 15.0003C12.581 15.0003 12.9168 14.6645 12.9168 14.2503V9.25033Z"
                                                        fill=""></path>
                                                </svg>
                                            </button>
                                            <button @click="editRow(category.id)"
                                                class="text-gray-500 hover:text-accent dark:text-gray-400 dark:hover:text-accent">
                                                <svg class="fill-current" width="21" height="21"
                                                    viewBox="0 0 21 21" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M17.0911 3.53206C16.2124 2.65338 14.7878 2.65338 13.9091 3.53206L5.6074 11.8337C5.29899 12.1421 5.08687 12.5335 4.99684 12.9603L4.26177 16.445C4.20943 16.6931 4.286 16.9508 4.46529 17.1301C4.64458 17.3094 4.90232 17.3859 5.15042 17.3336L8.63507 16.5985C9.06184 16.5085 9.45324 16.2964 9.76165 15.988L18.0633 7.68631C18.942 6.80763 18.942 5.38301 18.0633 4.50433L17.0911 3.53206ZM14.9697 4.59272C15.2626 4.29982 15.7375 4.29982 16.0304 4.59272L17.0027 5.56499C17.2956 5.85788 17.2956 6.33276 17.0027 6.62565L16.1043 7.52402L14.0714 5.49109L14.9697 4.59272ZM13.0107 6.55175L6.66806 12.8944C6.56526 12.9972 6.49455 13.1277 6.46454 13.2699L5.96704 15.6283L8.32547 15.1308C8.46772 15.1008 8.59819 15.0301 8.70099 14.9273L15.0436 8.58468L13.0107 6.55175Z"
                                                        fill=""></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </template>

                        <template x-if="paginatedcategories.length === 0">
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-500">
                                    No categories found
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 dark:border-white/[0.05]">
            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between">
                <p
                    class="pb-3 text-sm font-medium text-center text-gray-500 border-b border-gray-100 dark:border-gray-800 dark:text-gray-400 xl:border-b-0 xl:pb-0 xl:text-left">
                    <template x-if="totalEntries > 0">
                        <span>
                            Showing <span x-text="start"></span>
                            to <span x-text="end"></span>
                            of <span x-text="totalEntries"></span> categories
                        </span>
                    </template>

                    <template x-if="totalEntries === 0">
                        <span>No categories available</span>
                    </template>
                </p>
                <div class="flex items-center justify-center gap-0.5 pt-4 xl:justify-end xl:pt-0">
                    <button @click="prevPage" :disabled="currentPage === 1 || totalEntries === 0"
                        :class="(currentPage === 1 || totalEntries === 0) ? 'opacity-50 cursor-not-allowed' : ''"
                        class="mr-2.5 flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-gray-700 shadow-theme-xs hover:bg-gray-50 disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M2.58301 9.99868C2.58272 10.1909 2.65588 10.3833 2.80249 10.53L7.79915 15.5301C8.09194 15.8231 8.56682 15.8233 8.85981 15.5305C9.15281 15.2377 9.15297 14.7629 8.86018 14.4699L5.14009 10.7472L16.6675 10.7472C17.0817 10.7472 17.4175 10.4114 17.4175 9.99715C17.4175 9.58294 17.0817 9.24715 16.6675 9.24715L5.14554 9.24715L8.86017 5.53016C9.15297 5.23717 9.15282 4.7623 8.85983 4.4695C8.56684 4.1767 8.09197 4.17685 7.79917 4.46984L2.84167 9.43049C2.68321 9.568 2.58301 9.77087 2.58301 9.99715C2.58301 9.99766 2.58301 9.99817 2.58301 9.99868Z"
                                fill="currentColor" />
                        </svg>
                        {{-- <span class="hidden sm:inline">Previous</span> --}}
                    </button>

                    <ul class="hidden items-center gap-0.5 sm:flex">
                        <template x-for="page in displayedPages" :key="page">
                            <li>
                                <button x-show="page !== '...'" @click="goToPage(page)"
                                    :class="currentPage === page ? 'bg-main text-white' :
                                        'text-gray-700 hover:bg-main/[0.08] hover:text-main dark:text-gray-400 dark:hover:text-main'"
                                    class="flex h-10 w-10 items-center justify-center rounded-lg text-theme-sm font-medium"
                                    x-text="page"></button>
                                <span x-show="page === '...'"
                                    class="flex h-10 w-10 items-center justify-center text-gray-500">...</span>
                            </li>
                        </template>
                    </ul>

                    <button @click="nextPage" :disabled="currentPage === totalPages || totalEntries === 0"
                        :class="(currentPage === totalPages || totalEntries === 0) ? 'opacity-50 cursor-not-allowed' : ''"
                        class="ml-2.5 flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-gray-700 shadow-theme-xs hover:bg-gray-50 disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M17.4175 9.9986C17.4178 10.1909 17.3446 10.3832 17.198 10.53L12.2013 15.5301C11.9085 15.8231 11.4337 15.8233 11.1407 15.5305C10.8477 15.2377 10.8475 14.7629 11.1403 14.4699L14.8604 10.7472L3.33301 10.7472C2.91879 10.7472 2.58301 10.4114 2.58301 9.99715C2.58301 9.58294 2.91879 9.24715 3.33301 9.24715L14.8549 9.24715L11.1403 5.53016C10.8475 5.23717 10.8477 4.7623 11.1407 4.4695C11.4336 4.1767 11.9085 4.17685 12.2013 4.46984L17.1588 9.43049C17.3173 9.568 17.4175 9.77087 17.4175 9.99715C17.4175 9.99763 17.4175 9.99812 17.4175 9.9986Z"
                                fill="currentColor" />
                        </svg>
                    </button>

                </div>
            </div>
        </div>
    </div>

    <x-ui.modal x-data="{ open: false }" @open-add-category-modal.window="open = true" :isOpen="false"
        class="max-w-[700px]">
        <div
            class="no-scrollbar relative w-full max-w-[700px] overflow-y-auto rounded-3xl bg-white p-4 dark:bg-gray-900 lg:p-11">
            <div class="px-2 pr-14">
                <h4 class="mb-2 text-2xl font-semibold text-gray-800 dark:text-white/90">
                    Create New Category
                </h4>
                <p class="mb-6 text-sm text-gray-500 dark:text-gray-400 lg:mb-7">
                    Add a category to better organize and track your transactions.
                </p>
            </div>
            <form class="flex flex-col">
                <div class="custom-scrollbar overflow-y-auto p-2 flex flex-col gap-5">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Category Name
                        </label>
                        <div x-data="{
                            open: false,
                            icon: 'shopping-cart',
                            icons: [
                                'shopping-cart', 'home', 'user', 'chart-bar', 'tag',
                                'credit-card', 'truck', 'gift', 'wallet', 'banknotes'
                            ]
                        }" class="flex items-center relative gap-2">
                            <button type="button"
                                class="w-11 h-11 flex items-center justify-center border border-gray-300 rounded-lg dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800"
                                @click="open = !open">
                                <x-dynamic-component :component="'heroicon-o-' + icon" class="w-5 h-5" />
                            </button>
                            <div x-show="open" @click.outside="open = false"
                                class="absolute z-[999] mt-2 bg-white rounded-xl shadow p-3">
                                <div class="grid grid-cols-5 gap-2">
                                    <template x-for="item in icons" :key="item">
                                        <button @click="icon = item; open = false"
                                            class="p-2 hover:bg-gray-100 rounded flex items-center justify-center">
                                            <x-dynamic-component :component="'heroicon-o-' + item" class="w-5 h-5" />
                                        </button>
                                    </template>
                                </div>
                            </div>
                            <input type="text"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                        </div>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Monthly Budget
                        </label>
                        <div class="relative">
                            <span
                                class="absolute top-1/2 left-0 inline-flex h-11 -translate-y-1/2 items-center justify-center border-r border-gray-200 py-3 pr-3 pl-3.5 text-gray-500 dark:border-gray-800 dark:text-gray-400">
                                IDR
                            </span>
                            <input type="text" x-model="price" @input="price = formatRupiah($event.target.value)"
                                placeholder="0"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pl-16 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                        </div>
                    </div>
                    <div class="flex items-center gap-3 px-2 mt-6 lg:justify-end">
                        <button @click="open = false; window.dispatchEvent(new Event('reset-emoji'))" type="button"
                            class="flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] sm:w-auto">
                            Close
                        </button>
                        <button @click="saveProfile" type="button"
                            class="flex w-full justify-center rounded-lg bg-main px-4 py-2.5 text-sm font-medium text-white hover:bg-main-hover sm:w-auto">
                            Save Changes
                        </button>
                    </div>
            </form>
        </div>
    </x-ui.modal>
</div>
