<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      app()['cache']->forget('spatie.permission.cache');
      
       // create roles and assign existing permissions
      $permissions = [
        [
          'name' => 'user-browse',
          'guard_name' => 'web',
          'group_name' => 'user'
        ],
        [
          'name' => 'user-read',
          'guard_name' => 'web',
          'group_name' => 'user'
        ],
        [
          'name' => 'user-add',
          'guard_name' => 'web',
          'group_name' => 'user'
        ],
        [
          'name' => 'user-edit',
          'guard_name' => 'web',
          'group_name' => 'user'
        ],
        [
          'name' => 'user-delete',
          'guard_name' => 'web',
          'group_name' => 'user'
        ],
        [
          'name' => 'package-browse',
          'guard_name' => 'web',
          'group_name' => 'package'
        ],
        [
          'name' => 'package-read',
          'guard_name' => 'web',
          'group_name' => 'package'
        ],
        [
          'name' => 'package-add',
          'guard_name' => 'web',
          'group_name' => 'package'
        ],
        [
          'name' => 'package-edit',
          'guard_name' => 'web',
          'group_name' => 'package'
        ],
        [
          'name' => 'package-delete',
          'guard_name' => 'web',
          'group_name' => 'package'
        ],
        [
          'name' => 'blog-browse',
          'guard_name' => 'web',
          'group_name' => 'blog'
        ],
        [
          'name' => 'blog-read',
          'guard_name' => 'web',
          'group_name' => 'blog'
        ],
        [
          'name' => 'blog-add',
          'guard_name' => 'web',
          'group_name' => 'blog'
        ],
        [
          'name' => 'blog-edit',
          'guard_name' => 'web',
          'group_name' => 'blog'
        ],
        [
          'name' => 'blog-delete',
          'guard_name' => 'web',
          'group_name' => 'blog'
        ],
        [
          'name' => 'vlog-browse',
          'guard_name' => 'web',
          'group_name' => 'vlog'
        ],
        [
          'name' => 'vlog-read',
          'guard_name' => 'web',
          'group_name' => 'vlog'
        ],
        [
          'name' => 'vlog-add',
          'guard_name' => 'web',
          'group_name' => 'vlog'
        ],
        [
          'name' => 'vlog-edit',
          'guard_name' => 'web',
          'group_name' => 'vlog'
        ],
        [
          'name' => 'vlog-delete',
          'guard_name' => 'web',
          'group_name' => 'vlog'
        ],
        [
          'name' => 'travel-course-browse',
          'guard_name' => 'web',
          'group_name' => 'travel-course'
        ],
        [
          'name' => 'travel-course-read',
          'guard_name' => 'web',
          'group_name' => 'travel-course'
        ],
        [
          'name' => 'travel-course-add',
          'guard_name' => 'web',
          'group_name' => 'travel-course'
        ],
        [
          'name' => 'travel-course-edit',
          'guard_name' => 'web',
          'group_name' => 'travel-course'
        ],
        [
          'name' => 'travel-course-delete',
          'guard_name' => 'web',
          'group_name' => 'travel-course'
        ],
        [
          'name' => 'destination-browse',
          'guard_name' => 'web',
          'group_name' => 'destination'
        ],
        [
          'name' => 'destination-read',
          'guard_name' => 'web',
          'group_name' => 'destination'
        ],
        [
          'name' => 'destination-add',
          'guard_name' => 'web',
          'group_name' => 'destination'
        ],
        [
          'name' => 'destination-edit',
          'guard_name' => 'web',
          'group_name' => 'destination'
        ],
        [
          'name' => 'destination-delete',
          'guard_name' => 'web',
          'group_name' => 'destination'
        ],
        [
          'name' => 'service-browse',
          'guard_name' => 'web',
          'group_name' => 'service'
        ],
        [
          'name' => 'service-read',
          'guard_name' => 'web',
          'group_name' => 'service'
        ],
        [
          'name' => 'service-add',
          'guard_name' => 'web',
          'group_name' => 'service'
        ],
        [
          'name' => 'service-edit',
          'guard_name' => 'web',
          'group_name' => 'service'
        ],
        [
          'name' => 'service-delete',
          'guard_name' => 'web',
          'group_name' => 'service'
        ],
        [
          'name' => 'category-browse',
          'guard_name' => 'web',
          'group_name' => 'category'
        ],
        [
          'name' => 'category-read',
          'guard_name' => 'web',
          'group_name' => 'category'
        ],
        [
          'name' => 'category-add',
          'guard_name' => 'web',
          'group_name' => 'category'
        ],
        [
          'name' => 'category-edit',
          'guard_name' => 'web',
          'group_name' => 'category'
        ],
        [
          'name' => 'category-delete',
          'guard_name' => 'web',
          'group_name' => 'category'
        ],
        [
          'name' => 'faq-browse',
          'guard_name' => 'web',
          'group_name' => 'faq'
        ],
        [
          'name' => 'faq-read',
          'guard_name' => 'web',
          'group_name' => 'faq'
        ],
        [
          'name' => 'faq-add',
          'guard_name' => 'web',
          'group_name' => 'faq'
        ],
        [
          'name' => 'faq-edit',
          'guard_name' => 'web',
          'group_name' => 'faq'
        ],
        [
          'name' => 'faq-delete',
          'guard_name' => 'web',
          'group_name' => 'faq'
        ],
        [
          'name' => 'address-browse',
          'guard_name' => 'web',
          'group_name' => 'address'
        ],
        [
          'name' => 'address-read',
          'guard_name' => 'web',
          'group_name' => 'address'
        ],
        [
          'name' => 'address-add',
          'guard_name' => 'web',
          'group_name' => 'address'
        ],
        [
          'name' => 'address-edit',
          'guard_name' => 'web',
          'group_name' => 'address'
        ],
        [
          'name' => 'address-delete',
          'guard_name' => 'web',
          'group_name' => 'address'
        ],
        [
          'name' => 'role-browse',
          'guard_name' => 'web',
          'group_name' => 'role'
        ],
        [
          'name' => 'role-read',
          'guard_name' => 'web',
          'group_name' => 'role'
        ],
        [
          'name' => 'role-add',
          'guard_name' => 'web',
          'group_name' => 'role'
        ],
        [
          'name' => 'role-edit',
          'guard_name' => 'web',
          'group_name' => 'role'
        ],
        [
          'name' => 'role-delete',
          'guard_name' => 'web',
          'group_name' => 'role'
        ],
        [
          'name' => 'permission-browse',
          'guard_name' => 'web',
          'group_name' => 'permission'
        ],
        [
          'name' => 'permission-read',
          'guard_name' => 'web',
          'group_name' => 'permission'
        ],
        [
          'name' => 'permission-add',
          'guard_name' => 'web',
          'group_name' => 'permission'
        ],
        [
          'name' => 'permission-edit',
          'guard_name' => 'web',
          'group_name' => 'permission'
        ],
        [
          'name' => 'permission-delete',
          'guard_name' => 'web',
          'group_name' => 'permission'
        ],
        [
          'name' => 'dashboard-browse',
          'guard_name' => 'web',
          'group_name' => 'dashboard'
        ],
        [
          'name' => 'app-setting-update',
          'guard_name' => 'web',
          'group_name' => 'app-setting'
        ],
        [
          'name' => 'promotion-and-discount-browse',
          'guard_name' => 'web',
          'group_name' => 'promotion-and-discount'
        ],
        [
          'name' => 'promotion-and-discount-read',
          'guard_name' => 'web',
          'group_name' => 'promotion-and-discount'
        ],
        [
          'name' => 'promotion-and-discount-add',
          'guard_name' => 'web',
          'group_name' => 'promotion-and-discount'
        ],
        [
          'name' => 'promotion-and-discount-edit',
          'guard_name' => 'web',
          'group_name' => 'promotion-and-discount'
        ],
        [
          'name' => 'promotion-and-discount-delete',
          'guard_name' => 'web',
          'group_name' => 'promotion-and-discount'
        ],
        [
          'name' => 'contact-us-browse',
          'guard_name' => 'web',
          'group_name' => 'contact-us'
        ],
        [
          'name' => 'contact-us-delete',
          'guard_name' => 'web',
          'group_name' => 'contact-us'
        ],
        [
          'name' => 'review-and-rating-browse',
          'guard_name' => 'web',
          'group_name' => 'review-and-rating'
        ],
        [
          'name' => 'review-and-rating-read',
          'guard_name' => 'web',
          'group_name' => 'review-and-rating'
        ],
        [
          'name' => 'review-and-rating-add',
          'guard_name' => 'web',
          'group_name' => 'review-and-rating'
        ],
        [
          'name' => 'review-and-rating-edit',
          'guard_name' => 'web',
          'group_name' => 'review-and-rating'
        ],
        [
          'name' => 'review-and-rating-delete',
          'guard_name' => 'web',
          'group_name' => 'review-and-rating'
        ],
        [
          'name' => 'newsletter-browse',
          'guard_name' => 'web',
          'group_name' => 'newsletter'
        ],
        [
          'name' => 'newsletter-delete',
          'guard_name' => 'web',
          'group_name' => 'newsletter'
        ],
        [
          'name' => 'pro-forma-invoice-browse',
          'guard_name' => 'web',
          'group_name' => 'pro-forma-invoice'
        ],
        [
          'name' => 'pro-forma-invoice-read',
          'guard_name' => 'web',
          'group_name' => 'pro-forma-invoice'
        ],
        [
          'name' => 'pro-forma-invoice-add',
          'guard_name' => 'web',
          'group_name' => 'pro-forma-invoice'
        ],
        [
          'name' => 'pro-forma-invoice-edit',
          'guard_name' => 'web',
          'group_name' => 'pro-forma-invoice'
        ],
        [
          'name' => 'pro-forma-invoice-delete',
          'guard_name' => 'web',
          'group_name' => 'pro-forma-invoice'
        ],
        [
          'name' => 'email-template-browse',
          'guard_name' => 'web',
          'group_name' => 'email-template'
        ],
        [
          'name' => 'email-template-read',
          'guard_name' => 'web',
          'group_name' => 'email-template'
        ],
        [
          'name' => 'email-template-add',
          'guard_name' => 'web',
          'group_name' => 'email-template'
        ],
        [
          'name' => 'email-template-edit',
          'guard_name' => 'web',
          'group_name' => 'email-template'
        ],
        [
          'name' => 'email-template-delete',
          'guard_name' => 'web',
          'group_name' => 'email-template'
        ],
        [
          'name' => 'dynamic-page-browse',
          'guard_name' => 'web',
          'group_name' => 'dynamic-page'
        ],
        [
          'name' => 'dynamic-page-read',
          'guard_name' => 'web',
          'group_name' => 'dynamic-page'
        ],
        [
          'name' => 'dynamic-page-add',
          'guard_name' => 'web',
          'group_name' => 'dynamic-page'
        ],
        [
          'name' => 'dynamic-page-edit',
          'guard_name' => 'web',
          'group_name' => 'dynamic-page'
        ],
        [
          'name' => 'dynamic-page-delete',
          'guard_name' => 'web',
          'group_name' => 'dynamic-page'
        ],
        [
          'name' => 'booking-inquiry-browse',
          'guard_name' => 'web',
          'group_name' => 'booking-inquiry'
        ],
        [
          'name' => 'booking-inquiry-read',
          'guard_name' => 'web',
          'group_name' => 'booking-inquiry'
        ],
        [
          'name' => 'booking-inquiry-add',
          'guard_name' => 'web',
          'group_name' => 'booking-inquiry'
        ],
        [
          'name' => 'booking-inquiry-edit',
          'guard_name' => 'web',
          'group_name' => 'booking-inquiry'
        ],
        [
          'name' => 'booking-inquiry-delete',
          'guard_name' => 'web',
          'group_name' => 'booking-inquiry'
        ],
        [
          'name' => 'bank-detail-browse',
          'guard_name' => 'web',
          'group_name' => 'bank-detail'
        ],
        [
          'name' => 'bank-detail-read',
          'guard_name' => 'web',
          'group_name' => 'bank-detail'
        ],
        [
          'name' => 'bank-detail-add',
          'guard_name' => 'web',
          'group_name' => 'bank-detail'
        ],
        [
          'name' => 'bank-detail-edit',
          'guard_name' => 'web',
          'group_name' => 'bank-detail'
        ],
        [
          'name' => 'bank-detail-delete',
          'guard_name' => 'web',
          'group_name' => 'travel-course'
        ],
        [
          'name' => 'activity-browse',
          'guard_name' => 'web',
          'group_name' => 'activity'
        ],
        [
          'name' => 'activity-read',
          'guard_name' => 'web',
          'group_name' => 'activity'
        ],
        [
          'name' => 'activity-add',
          'guard_name' => 'web',
          'group_name' => 'activity'
        ],
        [
          'name' => 'activity-edit',
          'guard_name' => 'web',
          'group_name' => 'activity'
        ],
        [
          'name' => 'activity-delete',
          'guard_name' => 'web',
          'group_name' => 'activity'
        ],
        [
          'name' => 'visa-browse',
          'guard_name' => 'web',
          'group_name' => 'visa'
        ],
        [
          'name' => 'visa-delete',
          'guard_name' => 'web',
          'group_name' => 'visa'
        ],

        [
          'name' => 'insurance-browse',
          'guard_name' => 'web',
          'group_name' => 'insurance'
        ],
        [
          'name' => 'insurance-delete',
          'guard_name' => 'web',
          'group_name' => 'insurance'
        ],
        [
          'name' => 'ads-management-browse',
          'guard_name' => 'web',
          'group_name' => 'ads-management'
        ],
        [
          'name' => 'ads-management-read',
          'guard_name' => 'web',
          'group_name' => 'ads-management'
        ],
        [
          'name' => 'ads-management-add',
          'guard_name' => 'web',
          'group_name' => 'ads-management'
        ],
        [
          'name' => 'ads-management-edit',
          'guard_name' => 'web',
          'group_name' => 'ads-management'
        ],
        [
          'name' => 'ads-management-delete',
          'guard_name' => 'web',
          'group_name' => 'ads-management'
        ],
        [
          'name' => 'brand-add',
          'guard_name' => 'web',
          'group_name' => 'brand'
        ],
        [
          'name' => 'brand-browse',
          'guard_name' => 'web',
          'group_name' => 'brand'
        ],
        [
          'name' => 'brand-delete',
          'guard_name' => 'web',
          'group_name' => 'brand'
        ],
        [
          'name' => 'file-upload-add',
          'guard_name' => 'web',
          'group_name' => 'file-upload'
        ],
        [
          'name' => 'file-upload-browse',
          'guard_name' => 'web',
          'group_name' => 'file-upload'
        ],
        [
          'name' => 'file-upload-delete',
          'guard_name' => 'web',
          'group_name' => 'file-upload'
        ],
        [
          'name' => 'career-add',
          'guard_name' => 'web',
          'group_name' => 'career'
        ],
        [
          'name' => 'career-list',
          'guard_name' => 'web',
          'group_name' => 'career'
        ],
        [
          'name' => 'career-edit',
          'guard_name' => 'web',
          'group_name' => 'career'
        ],
        [
          'name' => 'career-delete',
          'guard_name' => 'web',
          'group_name' => 'career'
        ],
        [
          'name' => 'gallery-browse',
          'guard_name' => 'web',
          'group_name' => 'gallery'
        ],
        [
          'name' => 'gallery-read',
          'guard_name' => 'web',
          'group_name' => 'gallery'
        ],
        [
          'name' => 'gallery-add',
          'guard_name' => 'web',
          'group_name' => 'gallery'
        ],
        [
          'name' => 'gallery-edit',
          'guard_name' => 'web',
          'group_name' => 'gallery'
        ],
        [
          'name' => 'gallery-delete',
          'guard_name' => 'web',
          'group_name' => 'gallery'
        ],
      ];
      foreach ($permissions as $key => $permission) {
        Permission::create($permission);
      }
    }
}
