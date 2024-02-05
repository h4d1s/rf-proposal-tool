<?php

use App\Http\Controllers\Api\ApiCustomerController;
use App\Http\Controllers\Api\ApiClientController;
use App\Http\Controllers\Api\ApiCollectionController;
use App\Http\Controllers\Api\ApiCompanyController;
use App\Http\Controllers\Api\ApiProductController;
use App\Http\Controllers\Api\ApiProjectController;
use App\Http\Controllers\Api\ApiProposalController;
use App\Http\Controllers\Api\ApiServiceController;
use App\Http\Controllers\Api\ApiServiceTemplateController;
use App\Http\Controllers\Api\ApiPricingTableController;
use App\Http\Controllers\Api\ApiPricingTableItemController;
use App\Http\Controllers\Api\ApiDiscussionController;
use App\Http\Controllers\Api\ApiEmailTemplateController;
use App\Http\Controllers\Web\CheckoutController;
use App\Http\Controllers\Web\ClientController;
use App\Http\Controllers\Web\CollectionController;
use App\Http\Controllers\Web\CompanyController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\DiscussionController;
use App\Http\Controllers\Web\EmailTemplateController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\NoteController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\ProjectController;
use App\Http\Controllers\Web\ProposalController;
use App\Http\Controllers\Web\ServiceTemplateController;
use App\Http\Controllers\Web\ServiceTemplateItemController;
use App\Http\Controllers\Web\SettingsController;
use App\Http\Controllers\Web\UserController;
use App\Models\Collection;
use App\Models\Product;
use App\Models\Project;
use App\Models\Proposal;
use App\Models\Client;
use App\Models\Company;
use App\Models\EmailTemplate;
use App\Models\PricingTable;
use App\Models\PricingTableItem;
use App\Models\ServiceTemplate;
use App\Models\ServiceTemplateItem;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::get('/', HomeController::class)
        ->name('home');

    Route::get('/dashboard', DashboardController::class)
        ->name('dashboard');

    // Products
    Route::resource(
        'products', ProductController::class
    )->except([
        'create', 'store',
    ]);

    // Proposals
    Route::get('/proposals/export', [ProposalController::class, 'exportCsv'])
        ->name('proposals.export')
        ->can('viewAny', Proposal::class);
    Route::get('/proposals/send/{proposal}', [ProposalController::class, 'send'])
        ->name('proposals.send')
        ->can('viewAny', Proposal::class);
    Route::get('/proposals/create/{tab?}', [ProposalController::class, 'create'])
        ->name('proposals.create')
        ->can('create', Proposal::class);
    Route::resource(
        'proposals', ProposalController::class
    )->except([
        'create',
        'edit'
    ]);
    Route::get('/proposals/{proposal}/edit/{tab?}', [ProposalController::class, 'edit'])
        ->name('proposals.edit')
        ->can('update', 'proposal');
    Route::get('/proposals/{proposal}/delete', [ProposalController::class, 'destroy'])
        ->name('proposals.delete')
        ->can('delete', 'proposal');
    Route::get('/proposals/{proposal}/export/pdf', [ProposalController::class, 'exportPdf'])
        ->name('proposals.exportPdf')
        ->can('viewAny', Proposal::class);

    Route::resources([
        'clients' => ClientController::class,
        'collections' => CollectionController::class,
        'projects' => ProjectController::class,
        'companies' => CompanyController::class,
    ]);

    // Projects
    Route::get('/projects/{project}/delete', [ProjectController::class, 'destroy'])
        ->name('projects.delete')
        ->can('delete', 'project');

    // Companies
    Route::get('/companies/{company}/delete', [CompanyController::class, 'destroy'])
        ->name('companies.delete')
        ->can('delete', 'company');

    // Clients
    Route::get('/clients/{client}/delete', [ClientController::class, 'destroy'])
        ->name('clients.delete')
        ->can('delete', 'client');

    // Notes
    Route::get('/notes/{note}/delete', [NoteController::class, 'destroy'])
        ->name('notes.delete')
        ->can('delete', 'note');

    // Discussions
    Route::get('/discussions/{discussion}/delete', [DiscussionController::class, 'destroy'])
        ->name('discussions.delete')
        ->can('delete', 'discussion');

    // ------------------------------------
    // Settings

    Route::get('/settings', [SettingsController::class, 'index'])
        ->name('settings.index')
        ->can('viewAny', Setting::class);

    Route::get('settings/edit', [SettingsController::class, 'edit'])
        ->name('settings.edit')
        ->can('viewAny', Setting::class);

    Route::patch('settings/update', [SettingsController::class, 'update'])
        ->name('settings.update')
        ->can('viewAny', Setting::class);

    // Users
    Route::resources([
        'settings/users' => UserController::class,
    ]);
    Route::get('settings/users/{user}/delete', [UserController::class, 'destroy'])
        ->name('users.delete')
        ->can('delete', 'user');
    Route::get('settings/profile', [UserController::class, 'profile'])
        ->name('profile');

    // Email templates
    Route::resources([
        'settings/email-templates' => EmailTemplateController::class,
    ]);
    Route::get('settings/email-templates/{email_template}/delete', [EmailTemplateController::class, 'destroy'])
        ->name('email-templates.delete')
        ->can('delete', 'email_template');

    // Service templates
    Route::resources([
        'settings/service-templates' => ServiceTemplateController::class,
        'settings/service-templates.service-template-items' => ServiceTemplateItemController::class
    ]);
    Route::get('settings/service-templates/{service_template}/delete', [ServiceTemplateController::class, 'destroy'])
        ->name('service-templates.delete')
        ->can('delete', 'service_template');
    Route::get('settings/service-templates/{service_template}/service-template-items/{service_template_item}/delete', [ServiceTemplateItemController::class, 'destroy'])
        ->name('service-templates.service-template-items.delete')
        ->can('delete', 'service_template_item');

    // AJAX
    Route::prefix('ajax')->group(function () {
        Route::get('/clients', [ApiClientController::class, 'index'])
            ->can('viewAny', Client::class);
        Route::get('/clients/{client}', [ApiClientController::class, 'show'])
            ->can('view', 'client');

        Route::get('/products', [ApiProductController::class, 'index'])
            ->can('viewAny', Product::class);

        Route::get('/projects', [ApiProjectController::class, 'index'])
            ->can('viewAny', Project::class);
        Route::get('/projects/{project}', [ApiProjectController::class, 'show'])
            ->can('view', 'project');

        Route::get('/proposals', [ApiProposalController::class, 'index'])
            ->can('viewAny', Proposal::class);

        Route::get('/collections', [ApiCollectionController::class, 'index'])
            ->can('viewAny', Collection::class);

        Route::get('/services', [ApiServiceController::class, 'index'])
            ->can('viewAny', ServiceTemplateItem::class);

        Route::get('/pricing-tables', [ApiPricingTableController::class, 'index'])
            ->can('viewAny', PricingTable::class);
        Route::get('/pricing-tables/{pricing_table}', [ApiPricingTableController::class, 'show'])
            ->can('view', 'pricing_table');

        Route::get('/pricing-table-items', [ApiPricingTableItemController::class, 'index'])
            ->can('viewAny', PricingTableItem::class);
        Route::delete('/pricing-table-items/{pricing_table_item}', [ApiPricingTableItemController::class, 'destroy'])
            ->can('delete', 'pricing_table_item');

        Route::get('/service-templates', [ApiServiceTemplateController::class, 'index'])
            ->can('viewAny', ServiceTemplate::class);

        Route::get('/email-templates/{email_template}', [ApiEmailTemplateController::class, 'show'])
            ->can('view', 'email_template');

        Route::get('/companies/{company}', [ApiCompanyController::class, 'show'])
            ->can('view', 'company');

        Route::get('/customers/{id}', [ApiCustomerController::class, 'show']);

        Route::prefix('search')->group(function () {
            Route::get('/clients', [ApiClientController::class, 'search'])
                ->can('viewAny', Client::class);
            Route::get('/projects', [ApiProjectController::class, 'search'])
                ->can('viewAny', Project::class);
            Route::get('/collections', [ApiCollectionController::class, 'search'])
                ->can('viewAny', Collection::class);
            Route::get('/email-templates', [ApiEmailTemplateController::class, 'search'])
                ->can('viewAny', EmailTemplate::class);
            Route::get('/companies', [ApiCompanyController::class, 'search'])
                ->can('viewAny', Company::class);
            Route::get('/customers', [ApiCustomerController::class, 'search'])
                ->can('viewAny', [Client::class, Company::class]);
        });
    });
});

Route::middleware(['web'])->group(function () {
    // Proposal
    Route::post('/proposals/action/{proposal}', [ProposalController::class, 'action'])
        ->name('proposals.action');
    Route::get('/proposals/{proposal}', [ProposalController::class, 'show'])
        ->name('proposals.show');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout');
    Route::post('/process-payment', [CheckoutController::class, 'processPayment'])
        ->name('checkout.process-payment');

    // AJAX
    Route::prefix('ajax')->group(function () {
        Route::get('/discussion', [ApiDiscussionController::class, 'index']);
        Route::post('/discussion', [ApiDiscussionController::class, 'create']);
    });
});

require __DIR__.'/auth.php';
