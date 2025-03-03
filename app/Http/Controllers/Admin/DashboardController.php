<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Service;
use App\Models\Project;
use App\Models\Customer;
use App\Models\Certificate;
use App\Models\ContactForm;

class DashboardController extends Controller
{
    public function index()
    {
        try {
           
          


            \Log::info('Statistics:', $statistics);

           
            $latest_products = Product::with('category')
                ->latest()
                ->take(5)
                ->get();
            
            $latest_messages = ContactForm::latest()
                ->take(5)
                ->get();

            return view('back.pages.index', compact('statistics', 'latest_products', 'latest_messages'));

        } catch (\Exception $e) {
            \Log::error('Dashboard Error: ' . $e->getMessage());
            
           
           

            $latest_products = collect([]);
            $latest_messages = collect([]);

      
        }
    }
}