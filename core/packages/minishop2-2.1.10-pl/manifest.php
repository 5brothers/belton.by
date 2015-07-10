<?php return array (
  'manifest-version' => '1.1',
  'manifest-attributes' => 
  array (
    'changelog' => 'Changelog for miniShop2.

2.1.10 pl
==============
- Added support of Tickets 1.6.

2.1.9 beta
==============
- Fixed modification of order price by delivery and payment in default order handler.
- Fixed processing of decimal prices in PayPal payment class.
- Improved chunk tpl.msOrder.payment.

2.1.8 pl3
==============
- Fixed controllers for MODX 2.3.
- Fixed routes to processors for MODX 2.3.
- Fixed product getlist processor for MODX 2.3.
- Fixed sorting products in category grid by clicking on column header.
- Disabled Bootstrap icons for MODX 2.3.
- Fixed product gallery for MODX 2.3.
- Fixed issue with deleting product files children in MODX 2.3.
- Fixed "autocomplete_err_noquery" error in MODX 2.3.
- [#148] Fixed duplicate connector.
- Fixed work of "minishop2-combo-user" in MODX 2.3.

2.1.8 beta
==============
- Added field "name" in object msOrderProduct for storing pagetitle of the product.
- Fixed log level in PayPal method.
- Added integer field "type" to msOrder.
- Fixed CustomerProfile connection in schema.
- Improved price and weight formatting in orders table.
- Some UI improvements and fixes.

2.1.7 pl5
==============
- [#131] Fixed update of product thumb when you update thumbnails.
- [#129] [msGetOrder] Fixed setting of placeholders.
- Fixed work with comments on product panel.
- [msOrder] Now snippet loads "building", "room" and "comment" from extended field of users profile.
- [mgr] Fixed parameter "maxUploadSize" in gallery.

2.1.7 pl1
==============
- [#119] Improved compatibility with AjaxManager.
- [#118] Fixed negative cost in payment and delivery methods.
- [#113] Added Lithuanian lexicons.
- [#112] Restrict cart items to specific contexts.
- [#111] Fixed remove of products links.
- [#107] Fixed empty customer field if fullname is not specified.
- [#106] Additional check of friendly filename in gallery.
- New system setting "ms2_category_remember_grid".

2.1.6 pl4
==============
- [#110] Fix generate thumbs on upload for Amazon S3.
- Fixed counting money spent in new customers.
- [#104] Fixed placeholder [[+cart_weight]] in emails.
- [#102] Improved checking of thumbnails url.
- [#98] Refactored permissions in processors.
- [#94] Formatted placeholder [[+cost]] in snippet msCart
- [#78] Fixed setting flag isfolder to false for old category of the product.
- Fixed handling of non-ajax requests.
- Removed unnecessary ajax request on add to cart. Fixed possibly E_NOTICE.

2.1.5 pl
==============
- Improved rename of files in gallery.
- Added default media source in product "create" processor.
- Added default template in product "create" processor.
- Added buttons in orders management page.

2.1.4 pl5
==============
- Added script for import products in core/components/minishop2/import/csv.php.
- Fixed icons in chunks.
- [#95] Fixed price and weight format.
- Improved installator. Now you can update chunks on install.
- Fixed possible errors on thumbnail generation.
- Progressive thumbnails in gallery.

2.1.3 pl2
==============
- Support Bootstrap3.
- Fixed E_WARNING in snippet msOptions.
- Fixed bug with php-apc on create order.

2.1.2 pl2
==============
- Fixed possibly E_NOTICE in snippets.

2.1.2 pl
==============
- [#77] Fixed change type of existing resource to "msProduct".
- Added ability to hide tabs of product page in manager. See new system settings.
- Improved style of horizontal product tabs.
- Improved proportions in settings tab of category.
- Improved rename of product images.
- Improved retrieving of first thumbnail of image in gallery.
- If you specified wrong "ms2_product_thumbnail_size" parameter, gallery will still work.
- Added support of non-image files in gallery.
- Improved snippet "msGallery" for display non-image files.
- [#84] Fixed displaying of  email of vendor in manager.

2.1.1 pl2
==============
- Fixed parameter "&parents" in msProducts.

2.1.1 pl
==============
- Snippet msProducts supports pdoTools 1.8.0. Parameter "&showHidden" enabled by default.
- Fixed fatal error with "clearCache" when msProduct created trough processor and it`s parent is not msCategory.
- Improved generation of thumbnails.

2.1.1 pl
==============
- Fixed access permissions tab on product update.
- Fixed getPrice and getWeight calls in snippet msProducts.
- Improved xtype "minishop2-combo-user".
- Added support of component "msDiscount".
- Added counting of total spent sum by every customer in msCustomerProfile.

2.1.0 pl2
==============
- Fixed placeholders on msProduct page due to issues with @INLINE chunks.

2.1.0 pl1
==============
- Added new events: "msOnGetProductPrice" and "msOnGetProductWeight".
- Fixed wrong events in database from previous release.
- Changed "vendor_" to "vendor." in msProduct::toArray() for sameness with the snippet msProducts.
- Moved all logic from old action.php to new plugin. File leaved for compatibility with users modified javascript.

2.1.0 pl
==============
- Changed default sort in goods grid on "menuindex, ASC".
- Improved method msDelivery::getCost().
- Added method msPayment::getCost().
- Improved method msOrderHandler::getCost(). Now you can specify additional percent for delivery and payment in manager.
- New object "msCustomerProfile". It can be extended by plugins like "msProductData".
- Plugin "miniShop2" can automatic save referrers.
- In snippet "msProducts" you can override "where", "select", "leftJoin", "innerJoin" and "rightJoin" properties. Added pdoFetch 1.4.1 support.
- Improved other snippets.
- Added new fields in "msProductFile": "hash" for sha1 of file and json field "properties".
- Changed uploader in product gallery to "Plupload" (Thanks to Alex Rahimov).
- Added check for duplicate images in product gallery by checking hash of the content of file.
- Added new parameters for media source: "maxUploadWidth" and "maxUploadHeight" for frontend image resize.
- Gallery upload processor now can receive parameters "id" and "file" for external images upload.
- Added renaming files of product gallery together with thumbnails.
- [#77] Fixed changing type of existing resource to "msCategory".
- [#76] Fixed parameter "offset" in msGallery.
- [#75] Remove multi-category links when category removed.
- [#74] Refresh data in order from users profile if he is authenticated.
- [#73] Added virtual vendor fields. You can get it by $res->get(\'vendor_name\');
- [#66] Fixed saving payments methods when create a new delivery.
- [#65] Added new system events: "msOnBeforeValidateOrderValue" and "msOnValidateOrderValue".
- [#64] Added ability to stop switching order status from system plugin.
- [#63] Added new parameters for media source: "imageNameType". Switching to "friendly" will generate names for uploaded files by FURLs algorithm.
- [#61] Added ability to sort products in category by drag and drop.
- [#62] Fixed work with "*.gif" files in products gallery.
- [#59] Improved regular expression for email verification.
- [#59] Improved validation of customer name and email when create order.
- [#59] msOrderHandler::add() now can return an error.
- [#59] Improved registration of javascript on frontend.
- [#59] Improved show\\hide of msMiniCart with css.
- [#59] Refactored default frontend javascript.
- [#59] Works with no javascript. (Thanks to Alexey Kartashov)
- [#58] Fixed PayPal non-USD currency.
- [#56] Added JSON field "properties" to "msProductFile".
- [#52] Added ability to customize orders in manager by 3 system setting: "ms2_order_grid_fields", "ms2_order_address_fields" and "ms2_order_product_fields".
- [#50] Fixed checking of the existence of the Tickets component.
- [#5] Possible fixed "Cannot execute queries while other unbuffered queries are active" on php < 5.3.
- Some fixes for MySql STRICT_TRANS_TABLES mode.
- Updated jQuery to version 1.10.2
- Added method PayPal::getPaymentLink() for continuing interrupted payment process. You will see [[+payment_link]] in emails.
- Added parameters "&tplSingle" and "&toSeparatePlaceholders" to snippet msGallery.
- Gallery UI improvements for MODX 2.2.9
- Returned action.php for backward compatibility with the old javascript

2.0.1 pl3
==============
- Added german lexicon.
- Now you can specify version of file in "ms2_frontend_js".
- [#60] Fixed type of field "index" in "msOrder".
- Improved listing of products in the categories of manager.

2.0.1 pl2
==============
- Improved submit of order form.
- msProducts saves order of ids received through &resources=``. It need for smooth work with mSearch2.
- [mgr] Fixed search in vendors combo

2.0.1 pl1
==============
- Added loading of lexicons for 3rd party payment methods. They must be named in "msp.%name%.inc.php" format.
- Added placeholder [[+payment_link]] in the new user email. It will work only if payment method has function getPaymentLink(msOrder $order);
- Removed placeholder [[+id]] from product page because of issues.
- [#53] Completely refactored call and processing plugin events.
- [#45] Added system setting for specify default content of category.

2.0.1 pl
==============
- Added 2 new events on order remove: "msOnBeforeRemoveOrder" and "msOnRemoveOrder".
- Improved classes: "msProduct" and "msCategory". Now $modx->getCollection(\'msProduct\'); returns only products.

2.0.1 beta3
==============
- Fixed msGallery

2.0.1 beta2
==============
- [#44] Enabled duplicate of category.
- [#42] Added parameter "returnIds" to snippet msProducts.
- [#41] Fixed panel with tvs on product create.
- Parameter "resources" not suppressing "parents" in msProducts anymore. Now they working together: resources that are not in parents will not be returned.
- Snippet msGallery now can to display placeholders like [[+600x]] or [[+x600]].
- Fixed display an original image in msGallery. If upgrade, replace placeholders [[+image]] to [[+url]] in chunk "tpl.msGallery.row" manually.
- Added setting placeholder [[+idx]] to snippets msGallery and msProducts.
- Added parameter "where" in snippet msGallery, for specify JSON encoded string with additional query data.
- Added parameters "limit" and "offset" for pagination. msGallery can be used with getPage now.

2.0.1 beta1
==============
- Maybe fixed bug with php-apc and sessions
- Fixed plugin params on events "msOnBeforeCreateOrder" and "msOnCreateOrder". Now you can change $msOrder by link.
- Fixed error with no changing status of order in manager.

2.0.1 beta
==============
- [#38] Added "menuindex" in product fields.
- [#37] Ability to override method miniShop2::changeOrderStatus() in custom order class.
- [#36] Removed filter_var(), because of issues on stupid hostings.
- [#35] Added 2 system setting to enable or disable the remembering of panel tabs.
- [#32] Enabled displaying of errors when uploading files in product gallery.
- [#30] "miniShopManagerPolicy" is automatically assigned to a group "Administrators".
- [#29] Added verification of object instance, when loading neighborhood resources in manager.
- [#28] Returned the lost fields in images of msGallery.
- [#27] Improved ajax requests in default javascript.
- [#26] Improvements of categories tree.
- [#25] Removed replacing of empty alias to id. Added 2 system setting for switching using resource id as alias for categories and products.
- Fixed quick fields in snippet msOrder. Update your chunks for delivery and payment methods.
- Improved "totalVar" placeholder in snippet msGallery.
- Fixed model. Added proper primary keys for xPDOObjects.
- Ability to load only "miniShop2Config" object on frontend, without default javascript and jQuery.
- Fixed parameter "depth" in snippet "msProducts".
- New permissions for work with order: "save" and "view". New events for update order.
- Added ability to add\\update\\remove products in order.

2.0.0 pl3
==============
- Compatibility with pdoTools 1.2.0

2.0.0 pl2
==============
- [mgr] Fixed formatting of dates in category grid.
- [mgr] Fixed decimals in product category grid.
- Added ability to create system setting "ms2_cart_max_count" to override maximum number of products for one operation.
- Fixed placeholders in emails subjects.
- Fixed generation of thumbnails in gallery for working with ImageMagick.
- Fixed link type "Many to many".
- Fixed requirement of non-existing permission "update_document" in processors.
- Added system setting "ms2_price_snippet" for modification of product price.
- Added system setting "ms2_weight_snippet" for modification of product weight.
- Product key in msCartHandler now generates with using "$price" and "$weight", because they can be modified when adding to cart.

2.0.0 pl1
==============
- [mgr] Changing of product image now cleans its cache.
- [mgr] New icons in tree
- Small improvements of the snippets at initialization.
- Added selection of product links in snippet msProducts. See the new snippet properties.
- Added ability to use msProducts with any modResource class.
- Added property "tvPrefix" to msProducts for compatibility with getResources.
- Added property "outputSeparator" to snippets msOptions and msProducts.
- Added system parameter "ms2_price_format" for specifying how to format price of product.
- Added system parameter "ms2_price_format_no_zeros" for optional removing extra zeros at the end of price.
- Added system parameter "ms2_weight_format" for specifying how to format weight of product.
- Added system parameter "ms2_weight_format_no_zeros" for optional removing extra zeros at the end of weight.

2.0.0 rc6
==============
- Fixed cleaning pdoTools in msGallery
- Improved saving payment method in order when quickly switch delivery.

2.0.0 rc5
==============
- Integration of PayPal express-checkout payment method.

2.0.0 rc4
==============
- Fixed bugs in snippets
- Fixed joining images by rank when includeThumbs.

2.0.0 rc
==============
- [mgr] Added displaying of nested products in categories. System setting "ms2_category_show_nested_products" can disable it.
- [mgr] Added the ability to link products together.
- [mgr] Added link to resource from ordered products.
- [mgr] Added ability to specify web document for Vendor by property "resource".
- [#6] Fixed error when order makes authenticated user without email.
- [#8] Fixed remove of order.
- [#9] Fixed date formatting in manager for working in Firefox.
- [#10] Added checking for negative value of adding products in cart.
- [#12] Added regeneration site maps after new product create.
- [#14] Added check of "register_globals" on cart/add.
- Added system setting "ms2_product_thumbnail_size" for setting default size of product thumbnail.
- Added vendor placeholders on product page. Now you can use [[+vendor.name]], [[+vendor.logo]] etc.
- Added beta scripts for console converting miniShop1 to miniShop2.
- Added partial french translation.
- Added method miniShop2::getTagged() from MS1.
- Added ability to load plugins, that can add new or overload existing product fields in model and manager.
- Added parameters for joining thumbnails and tvs in snippets msProducts, msCart and msGetOrder.
- Improved save of product options.
- Fixed automatic install of pdoTools.
- Fixed fetching images in snippet msGallery
- Other fixes and improvements.

2.0.0 beta-1
==============
- Added manager pages
- Added create and manage orders

2.0.0 beta-0
==============
- Initial release.',
    'license' => 'GNU GENERAL PUBLIC LICENSE
   Version 2, June 1991
--------------------------

Copyright (C) 1989, 1991 Free Software Foundation, Inc.
59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

Everyone is permitted to copy and distribute verbatim copies
of this license document, but changing it is not allowed.

Preamble
--------

  The licenses for most software are designed to take away your
freedom to share and change it.  By contrast, the GNU General Public
License is intended to guarantee your freedom to share and change free
software--to make sure the software is free for all its users.  This
General Public License applies to most of the Free Software
Foundation\'s software and to any other program whose authors commit to
using it.  (Some other Free Software Foundation software is covered by
the GNU Library General Public License instead.)  You can apply it to
your programs, too.

  When we speak of free software, we are referring to freedom, not
price.  Our General Public Licenses are designed to make sure that you
have the freedom to distribute copies of free software (and charge for
this service if you wish), that you receive source code or can get it
if you want it, that you can change the software or use pieces of it
in new free programs; and that you know you can do these things.

  To protect your rights, we need to make restrictions that forbid
anyone to deny you these rights or to ask you to surrender the rights.
These restrictions translate to certain responsibilities for you if you
distribute copies of the software, or if you modify it.

  For example, if you distribute copies of such a program, whether
gratis or for a fee, you must give the recipients all the rights that
you have.  You must make sure that they, too, receive or can get the
source code.  And you must show them these terms so they know their
rights.

  We protect your rights with two steps: (1) copyright the software, and
(2) offer you this license which gives you legal permission to copy,
distribute and/or modify the software.

  Also, for each author\'s protection and ours, we want to make certain
that everyone understands that there is no warranty for this free
software.  If the software is modified by someone else and passed on, we
want its recipients to know that what they have is not the original, so
that any problems introduced by others will not reflect on the original
authors\' reputations.

  Finally, any free program is threatened constantly by software
patents.  We wish to avoid the danger that redistributors of a free
program will individually obtain patent licenses, in effect making the
program proprietary.  To prevent this, we have made it clear that any
patent must be licensed for everyone\'s free use or not licensed at all.

  The precise terms and conditions for copying, distribution and
modification follow.


GNU GENERAL PUBLIC LICENSE
TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
---------------------------------------------------------------

  0. This License applies to any program or other work which contains
a notice placed by the copyright holder saying it may be distributed
under the terms of this General Public License.  The "Program", below,
refers to any such program or work, and a "work based on the Program"
means either the Program or any derivative work under copyright law:
that is to say, a work containing the Program or a portion of it,
either verbatim or with modifications and/or translated into another
language.  (Hereinafter, translation is included without limitation in
the term "modification".)  Each licensee is addressed as "you".

Activities other than copying, distribution and modification are not
covered by this License; they are outside its scope.  The act of
running the Program is not restricted, and the output from the Program
is covered only if its contents constitute a work based on the
Program (independent of having been made by running the Program).
Whether that is true depends on what the Program does.

  1. You may copy and distribute verbatim copies of the Program\'s
source code as you receive it, in any medium, provided that you
conspicuously and appropriately publish on each copy an appropriate
copyright notice and disclaimer of warranty; keep intact all the
notices that refer to this License and to the absence of any warranty;
and give any other recipients of the Program a copy of this License
along with the Program.

You may charge a fee for the physical act of transferring a copy, and
you may at your option offer warranty protection in exchange for a fee.

  2. You may modify your copy or copies of the Program or any portion
of it, thus forming a work based on the Program, and copy and
distribute such modifications or work under the terms of Section 1
above, provided that you also meet all of these conditions:

    a) You must cause the modified files to carry prominent notices
    stating that you changed the files and the date of any change.

    b) You must cause any work that you distribute or publish, that in
    whole or in part contains or is derived from the Program or any
    part thereof, to be licensed as a whole at no charge to all third
    parties under the terms of this License.

    c) If the modified program normally reads commands interactively
    when run, you must cause it, when started running for such
    interactive use in the most ordinary way, to print or display an
    announcement including an appropriate copyright notice and a
    notice that there is no warranty (or else, saying that you provide
    a warranty) and that users may redistribute the program under
    these conditions, and telling the user how to view a copy of this
    License.  (Exception: if the Program itself is interactive but
    does not normally print such an announcement, your work based on
    the Program is not required to print an announcement.)

These requirements apply to the modified work as a whole.  If
identifiable sections of that work are not derived from the Program,
and can be reasonably considered independent and separate works in
themselves, then this License, and its terms, do not apply to those
sections when you distribute them as separate works.  But when you
distribute the same sections as part of a whole which is a work based
on the Program, the distribution of the whole must be on the terms of
this License, whose permissions for other licensees extend to the
entire whole, and thus to each and every part regardless of who wrote it.

Thus, it is not the intent of this section to claim rights or contest
your rights to work written entirely by you; rather, the intent is to
exercise the right to control the distribution of derivative or
collective works based on the Program.

In addition, mere aggregation of another work not based on the Program
with the Program (or with a work based on the Program) on a volume of
a storage or distribution medium does not bring the other work under
the scope of this License.

  3. You may copy and distribute the Program (or a work based on it,
under Section 2) in object code or executable form under the terms of
Sections 1 and 2 above provided that you also do one of the following:

    a) Accompany it with the complete corresponding machine-readable
    source code, which must be distributed under the terms of Sections
    1 and 2 above on a medium customarily used for software interchange; or,

    b) Accompany it with a written offer, valid for at least three
    years, to give any third party, for a charge no more than your
    cost of physically performing source distribution, a complete
    machine-readable copy of the corresponding source code, to be
    distributed under the terms of Sections 1 and 2 above on a medium
    customarily used for software interchange; or,

    c) Accompany it with the information you received as to the offer
    to distribute corresponding source code.  (This alternative is
    allowed only for noncommercial distribution and only if you
    received the program in object code or executable form with such
    an offer, in accord with Subsection b above.)

The source code for a work means the preferred form of the work for
making modifications to it.  For an executable work, complete source
code means all the source code for all modules it contains, plus any
associated interface definition files, plus the scripts used to
control compilation and installation of the executable.  However, as a
special exception, the source code distributed need not include
anything that is normally distributed (in either source or binary
form) with the major components (compiler, kernel, and so on) of the
operating system on which the executable runs, unless that component
itself accompanies the executable.

If distribution of executable or object code is made by offering
access to copy from a designated place, then offering equivalent
access to copy the source code from the same place counts as
distribution of the source code, even though third parties are not
compelled to copy the source along with the object code.

  4. You may not copy, modify, sublicense, or distribute the Program
except as expressly provided under this License.  Any attempt
otherwise to copy, modify, sublicense or distribute the Program is
void, and will automatically terminate your rights under this License.
However, parties who have received copies, or rights, from you under
this License will not have their licenses terminated so long as such
parties remain in full compliance.

  5. You are not required to accept this License, since you have not
signed it.  However, nothing else grants you permission to modify or
distribute the Program or its derivative works.  These actions are
prohibited by law if you do not accept this License.  Therefore, by
modifying or distributing the Program (or any work based on the
Program), you indicate your acceptance of this License to do so, and
all its terms and conditions for copying, distributing or modifying
the Program or works based on it.

  6. Each time you redistribute the Program (or any work based on the
Program), the recipient automatically receives a license from the
original licensor to copy, distribute or modify the Program subject to
these terms and conditions.  You may not impose any further
restrictions on the recipients\' exercise of the rights granted herein.
You are not responsible for enforcing compliance by third parties to
this License.

  7. If, as a consequence of a court judgment or allegation of patent
infringement or for any other reason (not limited to patent issues),
conditions are imposed on you (whether by court order, agreement or
otherwise) that contradict the conditions of this License, they do not
excuse you from the conditions of this License.  If you cannot
distribute so as to satisfy simultaneously your obligations under this
License and any other pertinent obligations, then as a consequence you
may not distribute the Program at all.  For example, if a patent
license would not permit royalty-free redistribution of the Program by
all those who receive copies directly or indirectly through you, then
the only way you could satisfy both it and this License would be to
refrain entirely from distribution of the Program.

If any portion of this section is held invalid or unenforceable under
any particular circumstance, the balance of the section is intended to
apply and the section as a whole is intended to apply in other
circumstances.

It is not the purpose of this section to induce you to infringe any
patents or other property right claims or to contest validity of any
such claims; this section has the sole purpose of protecting the
integrity of the free software distribution system, which is
implemented by public license practices.  Many people have made
generous contributions to the wide range of software distributed
through that system in reliance on consistent application of that
system; it is up to the author/donor to decide if he or she is willing
to distribute software through any other system and a licensee cannot
impose that choice.

This section is intended to make thoroughly clear what is believed to
be a consequence of the rest of this License.

  8. If the distribution and/or use of the Program is restricted in
certain countries either by patents or by copyrighted interfaces, the
original copyright holder who places the Program under this License
may add an explicit geographical distribution limitation excluding
those countries, so that distribution is permitted only in or among
countries not thus excluded.  In such case, this License incorporates
the limitation as if written in the body of this License.

  9. The Free Software Foundation may publish revised and/or new versions
of the General Public License from time to time.  Such new versions will
be similar in spirit to the present version, but may differ in detail to
address new problems or concerns.

Each version is given a distinguishing version number.  If the Program
specifies a version number of this License which applies to it and "any
later version", you have the option of following the terms and conditions
either of that version or of any later version published by the Free
Software Foundation.  If the Program does not specify a version number of
this License, you may choose any version ever published by the Free Software
Foundation.

  10. If you wish to incorporate parts of the Program into other free
programs whose distribution conditions are different, write to the author
to ask for permission.  For software which is copyrighted by the Free
Software Foundation, write to the Free Software Foundation; we sometimes
make exceptions for this.  Our decision will be guided by the two goals
of preserving the free status of all derivatives of our free software and
of promoting the sharing and reuse of software generally.

NO WARRANTY
-----------

  11. BECAUSE THE PROGRAM IS LICENSED FREE OF CHARGE, THERE IS NO WARRANTY
FOR THE PROGRAM, TO THE EXTENT PERMITTED BY APPLICABLE LAW.  EXCEPT WHEN
OTHERWISE STATED IN WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES
PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED
OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE.  THE ENTIRE RISK AS
TO THE QUALITY AND PERFORMANCE OF THE PROGRAM IS WITH YOU.  SHOULD THE
PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF ALL NECESSARY SERVICING,
REPAIR OR CORRECTION.

  12. IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING
WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MAY MODIFY AND/OR
REDISTRIBUTE THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES,
INCLUDING ANY GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING
OUT OF THE USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED
TO LOSS OF DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY
YOU OR THIRD PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER
PROGRAMS), EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE
POSSIBILITY OF SUCH DAMAGES.

---------------------------
END OF TERMS AND CONDITIONS',
    'readme' => '--------------------
miniShop2
--------------------
Author: Vasiliy Naumkin <bezumkin@yandex.ru>
--------------------

Feel free to suggest ideas/improvements/bugs on GitHub:
http://github.com/bezumkin/miniShop2/issues',
    'chunks' => 
    array (
      'msProduct.content' => '<h1>[[*pagetitle]]</h1>
<div id="msProduct" class="row">
	<div class="span5 col-md-5">
		[[!msGallery]]
	</div>
	<div class="span7 col-md-7">
		<form class="form-horizontal ms2_form" method="post">
			<input type="hidden" name="id" value="[[*id]]" />
			<div class="form-group">
				<label class="col-sm-2 control-label">[[%ms2_product_article]]:</label>
				<div class="col-sm-3">
					<label class="checkbox">
						[[+article]]
					</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">[[%ms2_product_price]]:</label>
				<div class="col-sm-3">
					<label class="checkbox">
						[[!+price]] [[%ms2_frontend_currency]]
						[[!+old_price:gt=`0`:then=`<span class="old_price">[[+old_price]] [[%ms2_frontend_currency]]</span>`:else=``]]
					</label>
				</div>
			</div>
			<div class="form-group form-inline">
				<label class="col-sm-2 control-label" for="product_price">[[%ms2_cart_count]]:</label>
				<div class="col-sm-3">
					<input type="number" name="count" id="product_price" class="input-sm form-control" value="1" />
					[[%ms2_frontend_count_unit]]
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">[[%ms2_product_weight]]:</label>
				<div class="col-sm-3">
					<label class="checkbox">[[+weight]] [[%ms2_frontend_weight_unit]]</label>
				</div>
			</div>
			[[!msOptions?name=`color`]]
			[[!msOptions?name=`size`]]
			[[-!msOptions?name=`tags`&tplRow=``&tplOuter=``]]
			<div class="form-group">
				<label class="col-sm-2 control-label">[[%ms2_product_made_in]]:</label>
				<div class="col-sm-3">
					<label class="checkbox">[[+made_in]]</label>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-3">
					<button type="submit" class="btn btn-default" name="ms2_action" value="cart/add"><i class="glyphicon glyphicon-barcode"></i> [[%ms2_frontend_add_to_cart]]</button>
				</div>
			</div>
		</form>

	</div>
</div>
[[*content]]',
      'tpl.msCart.empty' => '[[%ms2_cart_is_empty]]',
      'tpl.msCart.outer' => '<div id="msCart">
	<table class="table table-striped">
		<tr class="header">
			<th class="image span2 col-md-2">&nbsp;</th>
			<th class="title span4 col-md-4">[[%ms2_cart_title]]</th>
			<th class="count span2 col-md-2">[[%ms2_cart_count]]</th>
			<th class="weight span1 col-md-1">[[%ms2_cart_weight]]</th>
			<th class="price span1 col-md-1">[[%ms2_cart_price]]</th>
			<th class="remove span2 col-md-2">[[%ms2_cart_remove]]</th>
		</tr>
		[[+goods]]
		<tr class="footer">
			<th class="total" colspan="2">[[%ms2_cart_total]]:</th>
			<th class="total_count"><span class="ms2_total_count">[[+total_count]]</span> [[%ms2_frontend_count_unit]]</th>
			<th class="total_weight"><span class="ms2_total_weight">[[+total_weight]]</span> [[%ms2_frontend_weight_unit]]</th>
			<th class="total_cost"><span class="ms2_total_cost">[[+total_cost]]</span> [[%ms2_frontend_currency]]</th>
			<th>&nbsp;</th>
		</tr>
	</table>
	<form method="post">
		<button class="btn btn-default" type="submit" name="ms2_action" value="cart/clean" title="[[%ms2_cart_clean]]"><i class="glyphicon glyphicon-remove"></i> [[%ms2_cart_clean]]</button>
	</form>
</div>',
      'tpl.msCart.row' => '<tr id="[[+key]]">
	<td class="image"><img src="[[+thumb:default=`[[++assets_url]]components/minishop2/img/web/ms2_small.png`]]" /></td>
	<td class="title"><a href="[[~[[+id]]]]">[[+pagetitle]]</a><br/>
		<small><i>[[+option.color]] [[+option.size]]</i></small>
	</td>
	<td class="count">
		<form method="post" class="ms2_form form-inline" role="form">
			<input type="hidden" name="key" value="[[+key]]" />
			<div class="form-group">
				<input type="number" name="count" value="[[+count]]" max-legth="4" class="input-sm form-control" />
				[[%ms2_frontend_count_unit]]
				<button class="btn btn-default" type="submit" name="ms2_action" value="cart/change"><i class="glyphicon glyphicon-refresh"></i></button>
			</div>
		</form>
	</td>
	<td class="weight"><span>[[+weight]]</span> [[%ms2_frontend_weight_unit]]</td>
	<td class="price"><span>[[+price]]</span> [[%ms2_frontend_currency]][[+old_price]]</td>
	<td class="remove">
		<form method="post" class="ms2_form">
			<input type="hidden" name="key" value="[[+key]]">
			<button class="btn btn-default" type="submit" name="ms2_action" value="cart/remove" title="[[%ms2_cart_remove]]"><i class="glyphicon glyphicon-remove"></i></button>
		</form>
	</td>
</tr>
<!--minishop2_option.color [[%ms2_frontend_color]]: [[+option.color]];-->
<!--minishop2_option.size [[%ms2_frontend_size]]: [[+option.size]];-->
<!--minishop2_old_price <br/><span class="old_price">[[+old_price]] [[%ms2_frontend_currency]]</span>-->',
      'tpl.msEmail.cancelled.user' => '[[!msGetOrder?id=`[[+id]]`]]

<h3>[[%ms2_email_subject_cancelled_user]]</h3>

<div id="msCart">
	<table class="table table-striped">
		<tr class="header">
			<th class="image span2 col-md-2">&nbsp;</th>
			<th class="title span4 col-md-4">[[%ms2_cart_title]]</th>
			<th class="count span2 col-md-2">[[%ms2_cart_count]]</th>
			<th class="weight span1 col-md-1">[[%ms2_cart_weight]]</th>
			<th class="price span1 col-md-1">[[%ms2_cart_cost]]</th>
		</tr>
		[[+goods]]
		<tr class="footer">
			<th class="total" colspan="2">[[%ms2_cart_total]]:</th>
			<th class="total_count"><span class="ms2_total_count">[[+cart_count]]</span> [[%ms2_frontend_count_unit]]</th>
			<th class="total_weight"><span class="ms2_total_weight">[[+cart_weight]]</span> [[%ms2_frontend_weight_unit]]</th>
			<th class="total_cost"><span class="ms2_total_cost">[[+cart_cost]]</span> [[%ms2_frontend_currency]]</th>
		</tr>
	</table>
	<h4>[[%ms2_frontend_order_cost]]: [[+cart_cost]] [[%ms2_frontend_currency]] + [[+delivery_cost]] [[%ms2_frontend_currency]] = <big>[[+cost]]</big> [[%ms2_frontend_currency]]</h4>
</div>',
      'tpl.msEmail.new.manager' => '[[!msGetOrder?id=`[[+id]]`]]

<h3>[[%ms2_email_subject_new_manager]]</h3>

<div id="msCart">
	<table class="table table-striped">
		<tr class="header">
			<th class="image span2 col-md-2">&nbsp;</th>
			<th class="title span4 col-md-4">[[%ms2_cart_title]]</th>
			<th class="count span2 col-md-2">[[%ms2_cart_count]]</th>
			<th class="weight span1 col-md-1">[[%ms2_cart_weight]]</th>
			<th class="price span1 col-md-1">[[%ms2_cart_cost]]</th>
		</tr>
		[[+goods]]
		<tr class="footer">
			<th class="total" colspan="2">[[%ms2_cart_total]]:</th>
			<th class="total_count"><span class="ms2_total_count">[[+cart_count]]</span> [[%ms2_frontend_count_unit]]</th>
			<th class="total_weight"><span class="ms2_total_weight">[[+cart_weight]]</span> [[%ms2_frontend_weight_unit]]</th>
			<th class="total_cost"><span class="ms2_total_cost">[[+cart_cost]]</span> [[%ms2_frontend_currency]]</th>
		</tr>
	</table>
	<h4>[[%ms2_frontend_order_cost]]: [[+cart_cost]] [[%ms2_frontend_currency]] + [[+delivery_cost]] [[%ms2_frontend_currency]] = <big>[[+cost]]</big> [[%ms2_frontend_currency]]</h4>
</div>',
      'tpl.msEmail.new.user' => '[[!msGetOrder?id=`[[+id]]`]]

<h3>[[%ms2_email_subject_new_user]]</h3>

<div id="msCart">
	<table class="table table-striped">
		<tr class="header">
			<th class="image span2 col-md-2">&nbsp;</th>
			<th class="title span4 col-md-4">[[%ms2_cart_title]]</th>
			<th class="count span2 col-md-2">[[%ms2_cart_count]]</th>
			<th class="weight span1 col-md-1">[[%ms2_cart_weight]]</th>
			<th class="price span1 col-md-1">[[%ms2_cart_cost]]</th>
		</tr>
		[[+goods]]
		<tr class="footer">
			<th class="total" colspan="2">[[%ms2_cart_total]]:</th>
			<th class="total_count"><span class="ms2_total_count">[[+cart_count]]</span> [[%ms2_frontend_count_unit]]</th>
			<th class="total_weight"><span class="ms2_total_weight">[[+cart_weight]]</span> [[%ms2_frontend_weight_unit]]</th>
			<th class="total_cost"><span class="ms2_total_cost">[[+cart_cost]]</span> [[%ms2_frontend_currency]]</th>
		</tr>
	</table>
	<h4>[[%ms2_frontend_order_cost]]: [[+cart_cost]] [[%ms2_frontend_currency]] + [[+delivery_cost]] [[%ms2_frontend_currency]] = <big>[[+cost]]</big> [[%ms2_frontend_currency]]</h4>
</div>

[[+payment_link]]',
      'tpl.msEmail.paid.manager' => '[[!msGetOrder?id=`[[+id]]`]]

<h3>[[%ms2_email_subject_paid_manager]]</h3>

<div id="msCart">
	<table class="table table-striped">
		<tr class="header">
			<th class="image span2 col-md-2">&nbsp;</th>
			<th class="title span4 col-md-4">[[%ms2_cart_title]]</th>
			<th class="count span2 col-md-2">[[%ms2_cart_count]]</th>
			<th class="weight span1 col-md-1">[[%ms2_cart_weight]]</th>
			<th class="price span1 col-md-1">[[%ms2_cart_cost]]</th>
		</tr>
		[[+goods]]
		<tr class="footer">
			<th class="total" colspan="2">[[%ms2_cart_total]]:</th>
			<th class="total_count"><span class="ms2_total_count">[[+cart_count]]</span> [[%ms2_frontend_count_unit]]</th>
			<th class="total_weight"><span class="ms2_total_weight">[[+cart_weight]]</span> [[%ms2_frontend_weight_unit]]</th>
			<th class="total_cost"><span class="ms2_total_cost">[[+cart_cost]]</span> [[%ms2_frontend_currency]]</th>
		</tr>
	</table>
	<h4>[[%ms2_frontend_order_cost]]: [[+cart_cost]] [[%ms2_frontend_currency]] + [[+delivery_cost]] [[%ms2_frontend_currency]] = <big>[[+cost]]</big> [[%ms2_frontend_currency]]</h4>
</div>',
      'tpl.msEmail.paid.user' => '[[!msGetOrder?id=`[[+id]]`]]

<h3>[[%ms2_email_subject_paid_user]]</h3>

<div id="msCart">
	<table class="table table-striped">
		<tr class="header">
			<th class="image span2 col-md-2">&nbsp;</th>
			<th class="title span4 col-md-4">[[%ms2_cart_title]]</th>
			<th class="count span2 col-md-2">[[%ms2_cart_count]]</th>
			<th class="weight span1 col-md-1">[[%ms2_cart_weight]]</th>
			<th class="price span1 col-md-1">[[%ms2_cart_cost]]</th>
		</tr>
		[[+goods]]
		<tr class="footer">
			<th class="total" colspan="2">[[%ms2_cart_total]]:</th>
			<th class="total_count"><span class="ms2_total_count">[[+cart_count]]</span> [[%ms2_frontend_count_unit]]</th>
			<th class="total_weight"><span class="ms2_total_weight">[[+cart_weight]]</span> [[%ms2_frontend_weight_unit]]</th>
			<th class="total_cost"><span class="ms2_total_cost">[[+cart_cost]]</span> [[%ms2_frontend_currency]]</th>
		</tr>
	</table>
	<h4>[[%ms2_frontend_order_cost]]: [[+cart_cost]] [[%ms2_frontend_currency]] + [[+delivery_cost]] [[%ms2_frontend_currency]] = <big>[[+cost]]</big> [[%ms2_frontend_currency]]</h4>
</div>',
      'tpl.msEmail.sent.user' => '[[!msGetOrder?id=`[[+id]]`]]

<h3>[[%ms2_email_subject_sent_user]]</h3>

<div id="msCart">
	<table class="table table-striped">
		<tr class="header">
			<th class="image span2 col-md-2">&nbsp;</th>
			<th class="title span4 col-md-4">[[%ms2_cart_title]]</th>
			<th class="count span2 col-md-2">[[%ms2_cart_count]]</th>
			<th class="weight span1 col-md-1">[[%ms2_cart_weight]]</th>
			<th class="price span1 col-md-1">[[%ms2_cart_cost]]</th>
		</tr>
		[[+goods]]
		<tr class="footer">
			<th class="total" colspan="2">[[%ms2_cart_total]]:</th>
			<th class="total_count"><span class="ms2_total_count">[[+cart_count]]</span> [[%ms2_frontend_count_unit]]</th>
			<th class="total_weight"><span class="ms2_total_weight">[[+cart_weight]]</span> [[%ms2_frontend_weight_unit]]</th>
			<th class="total_cost"><span class="ms2_total_cost">[[+cart_cost]]</span> [[%ms2_frontend_currency]]</th>
		</tr>
	</table>
	<h4>[[%ms2_frontend_order_cost]]: [[+cart_cost]] [[%ms2_frontend_currency]] + [[+delivery_cost]] [[%ms2_frontend_currency]] = <big>[[+cost]]</big> [[%ms2_frontend_currency]]</h4>
</div>',
      'tpl.msGallery.empty' => '<div id="msGallery">
	<img src="[[++assets_url]]components/minishop2/img/web/ms2_medium.png" width="360" height="270" alt="no photo" title="" />
</div>',
      'tpl.msGallery.outer' => '<div id="msGallery">
	<a rel="fancybox" href="[[+url:default=`/assets/components/minishop2/img/web/ms2_big.png`]]" target="_blank">
		<img src="[[+360x270:default=`/assets/components/minishop2/img/web/ms2_medium.png`]]" width="360" height="270" alt="" title="" id="mainImage" />
	</a>
	<div class="row">
		[[+rows]]
	</div>
</div>',
      'tpl.msGallery.row' => '<div class="span2 col-md-2">
	<a href="[[+360x270:default=`[[+url]]`]]" class="thumbnail" data-image="[[+url]]">
		<img src="[[+120x90]]" alt="" title="[[+name]]" width="120" height="90">
	</a>
</div>',
      'tpl.msGetOrder.row' => '<tr>
	<td class="image"><img src="[[++site_url]][[+thumb:default=`[[++assets_url]]components/minishop2/img/web/ms2_small.png`]]" /></td>
	<td class="title">[[+link:isnot=``:then=`<a href="[[+link]]">[[+name]]</a>`:else=`[[+name]]`]]<br/>
		<small><i>[[+option.color]] [[+option.size]]</i></small>
	</td>
	<td class="count">[[+count]] [[%ms2_frontend_count_unit]]</td>
	<td class="weight">[[+weight]] [[%ms2_frontend_weight_unit]]</td>
	<td class="price">[[+price]] [[%ms2_frontend_currency]]</td>
</tr>
<!--minishop2_option.color [[%ms2_frontend_color]]: [[+option.color]];-->
<!--minishop2_option.size [[%ms2_frontend_size]]: [[+option.size]];-->
',
      'tpl.msMiniCart' => '<div id="msMiniCart" [[+total_count:isnot=`0`:then=`class="full"`:else=``]]>
	<div class="empty">
		<h5><i class="glyphicon glyphicon-shopping-cart"></i> [[%ms2_minicart]]</h5>
		[[%ms2_minicart_is_empty]]
	</div>
	<div class="not_empty">
		<h5><i class="glyphicon glyphicon-shopping-cart"></i> [[%ms2_minicart]]</h5>
		[[%ms2_minicart_goods]]: <strong class="ms2_total_count">[[+total_count]]</strong> [[%ms2_frontend_count_unit]],
		[[%ms2_minicart_cost]]: <strong class="ms2_total_cost">[[+total_cost]]</strong> [[%ms2_frontend_currency]]
	</div>
</div>',
      'tpl.msOptions.outer' => '<div class="form-group">
	<label class="col-sm-2 control-label">[[%ms2_product_[[+name]]]]:</label>
	<div class="col-sm-3">
		<select name="options[[[+name]]]" class="form-control">[[+rows]]</select>
	</div>
</div>',
      'tpl.msOptions.row' => '<option value="[[+value]]" [[+selected]]>[[+value]]</option>',
      'tpl.msOrder.delivery' => '<div class="checkbox">
	<label class="delivery input-parent">
		<input type="radio" name="delivery" value="[[+id]]" id="delivery_[[+id]]" data-payments=\'[[+payments]]\' [[+checked]]>
		[[+logo:default=`[[+name]]`]] <!--&mdash; <i>[[+price]] [[%ms2_frontend_currency]]</i>-->
		[[+description]]
	</label>
</div>
<!--minishop2_logo <img src="[[+logo]]" />-->
<!--minishop2_description <p><small>[[+description]]</small></p>-->',
      'tpl.msOrder.outer' => '<form class="form-horizontal ms2_form" id="msOrder" method="post">
	<div class="row">
		<div class="span6 col-md-6">
			<h4>[[%ms2_frontend_credentials]]:</h4>
			<div class="form-group input-parent">
				<label class="col-sm-4 control-label" for="email"><span class="required-star">*</span> [[%ms2_frontend_email]]</label>
				<div class="col-sm-6">
					<input type="email" id="email" placeholder="[[%ms2_frontend_email]]" name="email" value="[[+email]]" class="form-control [[+errors.email]]">
				</div>
			</div>
			<div class="form-group input-parent">
				<label class="col-sm-4 control-label"  for="receiver"><span class="required-star">*</span> [[%ms2_frontend_receiver]]</label>
				<div class="col-sm-6">
					<input type="text" id="receiver" placeholder="[[%ms2_frontend_receiver]]" name="receiver" value="[[+receiver]]" class="form-control [[+errors.receiver]]">
				</div>
			</div>
			<div class="form-group input-parent">
				<label class="col-sm-4 control-label"  for="phone"><span class="required-star">*</span> [[%ms2_frontend_phone]]</label>
				<div class="col-sm-6">
					<input type="text" id="phone" placeholder="[[%ms2_frontend_phone]]" name="phone" value="[[+phone]]" class="form-control [[+errors.phone]]">
				</div>
			</div>
			<div class="form-group input-parent">
				<label class="col-sm-4 control-label"  for="comment"><span class="required-star">*</span> [[%ms2_frontend_comment]]</label>
				<div class="col-sm-6">
					<textarea name="comment" id="comment" placeholder="[[%ms2_frontend_comment]]" class="form-control [[+errors.comment]]">[[+comment]]</textarea>
				</div>
			</div>
		</div>
		<div class="span6 col-md-6" id="payments">
			<h4>[[%ms2_frontend_payments]]:</h4>
			<div class="form-group">
				<label class="col-sm-4 control-label" ><span class="required-star">*</span> [[%ms2_frontend_payment_select]]</label>
				<div class="col-sm-6">
					[[+payments]]
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="span6 col-md-6" id="deliveries">
			<h4>[[%ms2_frontend_deliveries]]:</h4>
			<div class="form-group">
				<label class="col-sm-4 control-label" ><span class="required-star">*</span> [[%ms2_frontend_delivery_select]]</label>
				<div class="col-sm-6">
					[[+deliveries]]
				</div>
			</div>
		</div>
		<div class="span6 col-md-6">
			<h4>[[%ms2_frontend_address]]:</h4>
			<div class="form-group input-parent">
				<label class="col-sm-4 control-label" for="index"><span class="required-star">*</span> [[%ms2_frontend_index]]</label>
				<div class="col-sm-4">
					<input type="text" id="index" placeholder="[[%ms2_frontend_index]]"  name="index" value="[[+index]]" class="form-control [[+errors.index]]">
				</div>
			</div>
			<div class="form-group input-parent">
				<label class="col-sm-4 control-label"  for="region"><span class="required-star">*</span> [[%ms2_frontend_region]]</label>
				<div class="col-sm-6">
					<input type="text" id="region" placeholder="[[%ms2_frontend_region]]" name="region" value="[[+region]]" class="form-control [[+errors.region]]">
				</div>
			</div>
			<div class="form-group input-parent">
				<label class="col-sm-4 control-label"  for="city"><span class="required-star">*</span> [[%ms2_frontend_city]]</label>
				<div class="col-sm-6">
					<input type="text" id="city" placeholder="[[%ms2_frontend_city]]" name="city" value="[[+city]]" class="form-control [[+errors.city]]">
				</div>
			</div>
			<div class="form-group input-parent">
				<label class="col-sm-4 control-label"  for="street"><span class="required-star">*</span> [[%ms2_frontend_street]]</label>
				<div class="col-md-6">
					<div class="col-md-4">
						<input type="text" id="street" placeholder="[[%ms2_frontend_street]]" name="street" value="[[+street]]" class="form-control [[+errors.street]]">
					</div>
					<div class="col-md-4">
						<input type="text" id="building" placeholder="[[%ms2_frontend_building]]" name="building" value="[[+building]]" class="form-control [[+errors.building]]">
					</div>
					<div class="col-md-4">
						<input type="text" id="room" placeholder="[[%ms2_frontend_room]]" name="room" value="[[+room]]" class="form-control [[+errors.room]]">
					</div>
				</div>
			</div>
		</div>
	</div>
	<button type="button" name="ms2_action" value="order/clean" class="btn btn-default ms2_link"><i class="glyphicon glyphicon-remove"></i> [[%ms2_frontend_order_cancel]]</button>
	<hr/>
	<div class="well">
		<div class="col-md-offset-2">
			<h3>[[%ms2_frontend_order_cost]]: <span id="ms2_order_cost">[[+order_cost:default=`0`]]</span> [[%ms2_frontend_currency]]</h3>
			<button type="submit" name="ms2_action" value="order/submit" class="btn btn-default btn-primary ms2_link">[[%ms2_frontend_order_submit]]</button>
		</div>
	</div>
</form>',
      'tpl.msOrder.payment' => '<div class="checkbox">
	<label class="payment input-parent">
		<input type="radio" name="payment" value="[[+id]]" id="payment_[[+id]]" [[+checked]]>
		[[+logo]]
		[[+description]]
	</label>
</div>
<!--minishop2_logo <img src="[[+logo]]" />-->
<!--minishop2_!logo [[+name]]-->
<!--minishop2_description <p><small>[[+description]]</small></p>-->
',
      'tpl.msOrder.success' => '[[!msGetOrder?id=`[[+id]]`]]

<h3>[[%ms2_frontend_order_success]]</h3>

<div id="msCart">
	<table class="table table-striped">
		<tr class="header">
			<th class="image span2 col-md-2">&nbsp;</th>
			<th class="title span4 col-md-4">[[%ms2_cart_title]]</th>
			<th class="count span2 col-md-2">[[%ms2_cart_count]]</th>
			<th class="weight span1 col-md-1">[[%ms2_cart_weight]]</th>
			<th class="price span1 col-md-1">[[%ms2_cart_cost]]</th>
		</tr>
		[[+goods]]
		<tr class="footer">
			<th class="total" colspan="2">[[%ms2_cart_total]]:</th>
			<th class="total_count"><span class="ms2_total_count">[[+cart_count]]</span> [[%ms2_frontend_count_unit]]</th>
			<th class="total_weight"><span class="ms2_total_weight">[[+cart_weight]]</span> [[%ms2_frontend_weight_unit]]</th>
			<th class="total_cost"><span class="ms2_total_cost">[[+cart_cost]]</span> [[%ms2_frontend_currency]]</th>
		</tr>
	</table>
	<h4>[[%ms2_frontend_order_cost]]: [[+cart_cost]] [[%ms2_frontend_currency]] + [[+delivery_cost]] [[%ms2_frontend_currency]] = <big>[[+cost]]</big> [[%ms2_frontend_currency]]</h4>
</div>',
      'tpl.msProducts.row' => '<div class="row ms2_product">
	<div class="span2 col-md-2"><img src="[[+thumb:default=`[[++assets_url]]components/minishop2/img/web/ms2_small.png`]]" width="120" height="90" /></div>
	<div class="row span10 col-md-10">
		<form method="post" class="ms2_form">
			<a href="[[~[[+id]]]]">[[+pagetitle]]</a>
			<span class="flags">[[+new]] [[+popular]] [[+favorite]]</span>
			<span class="price">[[+price]] [[%ms2_frontend_currency]]</span>
			[[+old_price]]
			<button class="btn btn-default" type="submit" name="ms2_action" value="cart/add"><i class="glyphicon glyphicon-barcode"></i> [[%ms2_frontend_add_to_cart]]</button>
			<input type="hidden" name="id" value="[[+id]]">
			<input type="hidden" name="count" value="1">
			<input type="hidden" name="options" value="[]">
		</form>
		<p><small>[[+introtext]]</small></p>
	</div>
</div>
<br/><br/>
<!--minishop2_popular <i class="glyphicon glyphicon-star" title="[[%ms2_frontend_popular]]"></i>-->
<!--minishop2_new <i class="glyphicon glyphicon-flag" title="[[%ms2_frontend_new]]"></i>-->
<!--minishop2_favorite <i class="glyphicon glyphicon-bookmark" title="[[%ms2_frontend_favorite]]"></i>-->
<!--minishop2_old_price <span class="old_price">[[+old_price]] [[%ms2_frontend_currency]]</span>-->',
    ),
    'setup-options' => 'minishop2-2.1.10-pl/setup-options.php',
  ),
  'manifest-vehicles' => 
  array (
    0 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modNamespace',
      'guid' => '6ff4b2e18575659f93d38402c9a85e3c',
      'native_key' => 'minishop2',
      'filename' => 'modNamespace/a9dd8f9698d7458edfd2ac76151bc7a1.vehicle',
      'namespace' => 'minishop2',
    ),
    1 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '558dae7a43c93b7912fb60c856bc73d3',
      'native_key' => 'ms2_category_grid_fields',
      'filename' => 'modSystemSetting/b90802ea49c37f16d04bfb13e0583ae7.vehicle',
      'namespace' => 'minishop2',
    ),
    2 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '156eb27918d1eff9c317f5e4324ea215',
      'native_key' => 'ms2_category_show_nested_products',
      'filename' => 'modSystemSetting/8273cb7fb52566ad68fe2baaee093f4e.vehicle',
      'namespace' => 'minishop2',
    ),
    3 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'e4cd5fda0738c91d486a574298301df5',
      'native_key' => 'ms2_category_show_comments',
      'filename' => 'modSystemSetting/bfedcdd837bc4b998bf44b23704de4b1.vehicle',
      'namespace' => 'minishop2',
    ),
    4 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'b3078c627cdac398f17d4c33814110e8',
      'native_key' => 'ms2_category_remember_tabs',
      'filename' => 'modSystemSetting/ae955fdd830a645090f7b2c1a0616bbb.vehicle',
      'namespace' => 'minishop2',
    ),
    5 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '0e3a02137f94e8cafdab4d3a5891a566',
      'native_key' => 'ms2_category_remember_grid',
      'filename' => 'modSystemSetting/c7905d328cb236dfa7a3b1bd20901435.vehicle',
      'namespace' => 'minishop2',
    ),
    6 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'aa95ec70a1c042e46dbdc17628341093',
      'native_key' => 'ms2_category_id_as_alias',
      'filename' => 'modSystemSetting/668077a938f2dcddaad01962baf1686e.vehicle',
      'namespace' => 'minishop2',
    ),
    7 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '6bdb861548ef7aa786813f4fabaafb4c',
      'native_key' => 'ms2_category_content_default',
      'filename' => 'modSystemSetting/9524441983749e01b6aa3aca45a1565b.vehicle',
      'namespace' => 'minishop2',
    ),
    8 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'ca5d8d80ad80aec469321156a9167eba',
      'native_key' => 'ms2_product_main_fields',
      'filename' => 'modSystemSetting/832ac3ecd3d788376a9efb68372ad7a7.vehicle',
      'namespace' => 'minishop2',
    ),
    9 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'fbd1b9a0b7a48f4a1844e25bd86a83a7',
      'native_key' => 'ms2_product_extra_fields',
      'filename' => 'modSystemSetting/460dc1831875803eec4bfdf5ed48f834.vehicle',
      'namespace' => 'minishop2',
    ),
    10 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'eed02703d8b71165240b6583b13facd6',
      'native_key' => 'ms2_product_show_comments',
      'filename' => 'modSystemSetting/ca56a6b96e4be354095dcdeb666f555d.vehicle',
      'namespace' => 'minishop2',
    ),
    11 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'cff3d64bd407a8656468de693c1e8ddf',
      'native_key' => 'ms2_template_product_default',
      'filename' => 'modSystemSetting/adc883da4934f0d687804e669e0c5767.vehicle',
      'namespace' => 'minishop2',
    ),
    12 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '0405c9f27eda0a6dcebaa09bb7e30cd4',
      'native_key' => 'ms2_product_show_in_tree_default',
      'filename' => 'modSystemSetting/233abecbae657fc605ab6a9a293d6c0f.vehicle',
      'namespace' => 'minishop2',
    ),
    13 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '5576188146a80fe95b7ccd2a5e37a2cf',
      'native_key' => 'ms2_product_source_default',
      'filename' => 'modSystemSetting/6ac9583606660ce202d58a7a291095ef.vehicle',
      'namespace' => 'minishop2',
    ),
    14 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'df67ca8dad935e2b9e06796a59c1c4f6',
      'native_key' => 'ms2_product_thumbnail_size',
      'filename' => 'modSystemSetting/6c859ed05cbc82a4fc2e4f04f2ffecd3.vehicle',
      'namespace' => 'minishop2',
    ),
    15 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '35a9795feb8567b7bf8626e925a991e5',
      'native_key' => 'ms2_product_vertical_tabs',
      'filename' => 'modSystemSetting/cdffc5c49429c2c6a89f8c5c82f1c118.vehicle',
      'namespace' => 'minishop2',
    ),
    16 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '375f240d382779383568e3a4e85cbc49',
      'native_key' => 'ms2_product_remember_tabs',
      'filename' => 'modSystemSetting/082a40823c4fa7cdfaae27a31ef73134.vehicle',
      'namespace' => 'minishop2',
    ),
    17 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '70aebc8afb16ad205fa3d6c3962f3dbb',
      'native_key' => 'ms2_product_id_as_alias',
      'filename' => 'modSystemSetting/72a1f762ebd5c5ae98ea7097926ed465.vehicle',
      'namespace' => 'minishop2',
    ),
    18 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'd9e478f328192eeeee6390dfde92788f',
      'native_key' => 'ms2_price_format',
      'filename' => 'modSystemSetting/923d375d253ec131370f4ff20af56867.vehicle',
      'namespace' => 'minishop2',
    ),
    19 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '147410861efacde8b3fc40bbcbeafa37',
      'native_key' => 'ms2_weight_format',
      'filename' => 'modSystemSetting/ec09b6e159def417a220dea1b275c86b.vehicle',
      'namespace' => 'minishop2',
    ),
    20 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '0c88732674d9060adf68b937ae9dcdf3',
      'native_key' => 'ms2_price_format_no_zeros',
      'filename' => 'modSystemSetting/97a0f4a41b2fd3c5878de41dd879016a.vehicle',
      'namespace' => 'minishop2',
    ),
    21 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '5718c284fefb513410e0fb03c1980d09',
      'native_key' => 'ms2_weight_format_no_zeros',
      'filename' => 'modSystemSetting/5cbd826ee32d3dbbabeef6c99716c796.vehicle',
      'namespace' => 'minishop2',
    ),
    22 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '9b9fd872474170350f96a497569e7cec',
      'native_key' => 'ms2_product_tab_extra',
      'filename' => 'modSystemSetting/e559e4be123e126bd8f0b9c6c090aafa.vehicle',
      'namespace' => 'minishop2',
    ),
    23 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '4e00d39f6c5185338789a8a63c1c93d6',
      'native_key' => 'ms2_product_tab_gallery',
      'filename' => 'modSystemSetting/53e4157fb95c20b258d0468d7a0e6aba.vehicle',
      'namespace' => 'minishop2',
    ),
    24 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '43ac16a680534a0793657a0248f5bab5',
      'native_key' => 'ms2_product_tab_links',
      'filename' => 'modSystemSetting/b6bcb95b7ba02b61dfb0c13c43ab59ea.vehicle',
      'namespace' => 'minishop2',
    ),
    25 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'd917ca3ad7fdef82ef2a29c1fe158fb8',
      'native_key' => 'ms2_cart_handler_class',
      'filename' => 'modSystemSetting/f6d65b4ea34ffde85c61e279aaf4c4ab.vehicle',
      'namespace' => 'minishop2',
    ),
    26 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '138f4df900f6e605df95472df2eb833b',
      'native_key' => 'ms2_order_grid_fields',
      'filename' => 'modSystemSetting/309ba27c549077fb537e5c0d26bc62f9.vehicle',
      'namespace' => 'minishop2',
    ),
    27 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '2ed2b82f1cd0017dde338ace27faf90f',
      'native_key' => 'ms2_order_address_fields',
      'filename' => 'modSystemSetting/d1f1507e72323a83831afe68df59f763.vehicle',
      'namespace' => 'minishop2',
    ),
    28 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'cd1bd2789369ad6d16da27641b9dcf99',
      'native_key' => 'ms2_order_product_fields',
      'filename' => 'modSystemSetting/60eb5843bdc087f18c02b3504101d4c1.vehicle',
      'namespace' => 'minishop2',
    ),
    29 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '2909f991f89d691a55737bb055cacb0a',
      'native_key' => 'ms2_order_handler_class',
      'filename' => 'modSystemSetting/7a6a68d235ce2580695aca0ab36f915c.vehicle',
      'namespace' => 'minishop2',
    ),
    30 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'd654d531cc8af5670af1ed060aec8082',
      'native_key' => 'ms2_order_user_groups',
      'filename' => 'modSystemSetting/c840da16770d72885e3960c04b63c2e9.vehicle',
      'namespace' => 'minishop2',
    ),
    31 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '776075df4513198fb51f279463d687c7',
      'native_key' => 'ms2_date_format',
      'filename' => 'modSystemSetting/9702c7d6d4f934830aed4fba91bd59a5.vehicle',
      'namespace' => 'minishop2',
    ),
    32 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '947f65a33eeb40ceadac50c555dc1bc9',
      'native_key' => 'ms2_email_manager',
      'filename' => 'modSystemSetting/0c254a76a54fba434a9e524d9ee3e74f.vehicle',
      'namespace' => 'minishop2',
    ),
    33 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '7598688e44f9f2ec52f3768516bba159',
      'native_key' => 'ms2_frontend_css',
      'filename' => 'modSystemSetting/d132c47c637893c40fafd5c21bb88903.vehicle',
      'namespace' => 'minishop2',
    ),
    34 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'befe3b6e8f4a55c014e31a8572aa79bb',
      'native_key' => 'ms2_frontend_js',
      'filename' => 'modSystemSetting/56f8677cf6ad5918bebd4e320fa1635d.vehicle',
      'namespace' => 'minishop2',
    ),
    35 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '876ac8cf0c54de89c56c7384475acd1b',
      'native_key' => 'ms2_payment_paypal_api_url',
      'filename' => 'modSystemSetting/0e645dc3c906af93f6c4fcbaf2340cc3.vehicle',
      'namespace' => 'minishop2',
    ),
    36 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'd067cb19a6698285aaad5abe78e261f0',
      'native_key' => 'ms2_payment_paypal_checkout_url',
      'filename' => 'modSystemSetting/ffe6bbe25147ecde08c1963d2f8c9474.vehicle',
      'namespace' => 'minishop2',
    ),
    37 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '13c52c5a84cf500f14c122270b771b38',
      'native_key' => 'ms2_payment_paypal_currency',
      'filename' => 'modSystemSetting/de36f2e01c8a96096578b5e2c497bd47.vehicle',
      'namespace' => 'minishop2',
    ),
    38 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'a2784e6ec6b027192676ae160a205c8e',
      'native_key' => 'ms2_payment_paypal_user',
      'filename' => 'modSystemSetting/20b81f567c5b233d88516ac8ca156dd1.vehicle',
      'namespace' => 'minishop2',
    ),
    39 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '1a7f78c2905d6a6958de15eb31d2d104',
      'native_key' => 'ms2_payment_paypal_pwd',
      'filename' => 'modSystemSetting/0f674acec78cc5297b5ff545a22ccc78.vehicle',
      'namespace' => 'minishop2',
    ),
    40 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'd8840c5fc30785bfa41032a405d5e0d8',
      'native_key' => 'ms2_payment_paypal_signature',
      'filename' => 'modSystemSetting/176614c7a1f0ddd7dddd370e016632d0.vehicle',
      'namespace' => 'minishop2',
    ),
    41 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '157292f0f533ca96ddf13edb3b8ceee3',
      'native_key' => 'ms2_payment_paypal_success_id',
      'filename' => 'modSystemSetting/391b3df96ac04bf51d393171ea6f8f3d.vehicle',
      'namespace' => 'minishop2',
    ),
    42 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'f7b42876fea62a30e6a6804bdf22a5df',
      'native_key' => 'ms2_payment_paypal_cancel_id',
      'filename' => 'modSystemSetting/7079a72b423dce0a7ba775035bc36559.vehicle',
      'namespace' => 'minishop2',
    ),
    43 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'f83a60fb6b49410079a8af729154d320',
      'native_key' => 'ms2_payment_paypal_cancel_order',
      'filename' => 'modSystemSetting/3208d132dc0a397420fc2aea4d3c15a1.vehicle',
      'namespace' => 'minishop2',
    ),
    44 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'adf5fcc39d819bfea480a204e7549611',
      'native_key' => 'msOnBeforeAddToCart',
      'filename' => 'modEvent/05d98d5e359bb7d070eec1594387a403.vehicle',
      'namespace' => 'minishop2',
    ),
    45 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'eb382a26028f6163232d571c7bb3f0dc',
      'native_key' => 'msOnAddToCart',
      'filename' => 'modEvent/7a8325fa85531c58b9a5cd5af85d811e.vehicle',
      'namespace' => 'minishop2',
    ),
    46 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'bc36a368a28979c5c9195441397a9896',
      'native_key' => 'msOnBeforeChangeInCart',
      'filename' => 'modEvent/fa4843f0aab2b6410a5dd6b0fec12aae.vehicle',
      'namespace' => 'minishop2',
    ),
    47 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'b6b133b162f7983391d87d9850765b58',
      'native_key' => 'msOnChangeInCart',
      'filename' => 'modEvent/1bd5f67e4a3b7993cfdbeddc6ec0f5a6.vehicle',
      'namespace' => 'minishop2',
    ),
    48 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'a96e063cd5ac51aa2bee18f72c6e8557',
      'native_key' => 'msOnBeforeRemoveFromCart',
      'filename' => 'modEvent/65a34ec114beffd0cce01e2f79e13904.vehicle',
      'namespace' => 'minishop2',
    ),
    49 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'eee2621b200bfce232ec8ee47168baed',
      'native_key' => 'msOnRemoveFromCart',
      'filename' => 'modEvent/472c36faa17a55490689db77f108843e.vehicle',
      'namespace' => 'minishop2',
    ),
    50 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '26208cec8018f8f6e19e45ca9d79823b',
      'native_key' => 'msOnBeforeEmptyCart',
      'filename' => 'modEvent/96fbff4ba649e9bbb802bf01deca4852.vehicle',
      'namespace' => 'minishop2',
    ),
    51 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '516b7cbf04c55c2868da5d5cda16fd45',
      'native_key' => 'msOnEmptyCart',
      'filename' => 'modEvent/8f38a6d0aba67176f9e6a958aae21094.vehicle',
      'namespace' => 'minishop2',
    ),
    52 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '5b7ee256913ed6fae09da4ba8c400790',
      'native_key' => 'msOnBeforeAddToOrder',
      'filename' => 'modEvent/e363c0e37eb6a3004d7aa69510d95bb6.vehicle',
      'namespace' => 'minishop2',
    ),
    53 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'd2423b18322c3582e787f2c71fb57668',
      'native_key' => 'msOnAddToOrder',
      'filename' => 'modEvent/9fff9f1bd560489622cc66fd9dc05950.vehicle',
      'namespace' => 'minishop2',
    ),
    54 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'd09a582d80557a6cdd158948d9a8dfa5',
      'native_key' => 'msOnBeforeRemoveFromOrder',
      'filename' => 'modEvent/0f6bac3f56dd9916e52b9f1f77a019ad.vehicle',
      'namespace' => 'minishop2',
    ),
    55 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '12a9cc2f546b317ff6a0273f82fdb4ca',
      'native_key' => 'msOnRemoveFromOrder',
      'filename' => 'modEvent/0fef28543e511c81579409f32f9726e6.vehicle',
      'namespace' => 'minishop2',
    ),
    56 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '1fc9dbeeb260fe871e88606860442b9c',
      'native_key' => 'msOnBeforeEmptyOrder',
      'filename' => 'modEvent/ed7163bd9403d140bbc466c16ce588b9.vehicle',
      'namespace' => 'minishop2',
    ),
    57 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'd4c1e7076b4f4af4476d257928be8bbc',
      'native_key' => 'msOnEmptyOrder',
      'filename' => 'modEvent/b9b6b55603ec32d588c29ce72bccdee3.vehicle',
      'namespace' => 'minishop2',
    ),
    58 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '410aacc96e3f493f1187730b90310a15',
      'native_key' => 'msOnBeforeChangeOrderStatus',
      'filename' => 'modEvent/5dd5ecb880f1d401c46f41b7ede7356d.vehicle',
      'namespace' => 'minishop2',
    ),
    59 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'dbc95cc85d15a70704f7263dd1bec075',
      'native_key' => 'msOnChangeOrderStatus',
      'filename' => 'modEvent/87927456ed6b225914f94688e1b68d30.vehicle',
      'namespace' => 'minishop2',
    ),
    60 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '766e20bf5f65f3cc090056cfbbd0cfd4',
      'native_key' => 'msOnBeforeUpdateOrder',
      'filename' => 'modEvent/106e86afbc04c5843364fa47fec346eb.vehicle',
      'namespace' => 'minishop2',
    ),
    61 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '25b2008da7ef0cf441da9ced930845b7',
      'native_key' => 'msOnUpdateOrder',
      'filename' => 'modEvent/d64788e7fafedb2ce20caf1e730097d3.vehicle',
      'namespace' => 'minishop2',
    ),
    62 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '9b9b9466b128955ae565326c5885f4bc',
      'native_key' => 'msOnBeforeCreateOrder',
      'filename' => 'modEvent/9663f968589e8d7643b2c45f59ede82e.vehicle',
      'namespace' => 'minishop2',
    ),
    63 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '45a906df962971f8ebc73b27505b6140',
      'native_key' => 'msOnCreateOrder',
      'filename' => 'modEvent/e231454dfffa13b7078f1c72caf25fa5.vehicle',
      'namespace' => 'minishop2',
    ),
    64 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '7ac0c6d9efe335db1ce71a6155258f74',
      'native_key' => 'msOnBeforeRemoveOrder',
      'filename' => 'modEvent/303fb28833f5f94c7b8c0e9d4617afa6.vehicle',
      'namespace' => 'minishop2',
    ),
    65 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '4e7ff7de85c7df79163210f0add11aa5',
      'native_key' => 'msOnRemoveOrder',
      'filename' => 'modEvent/67c6c24b9e99d761d54a5fe47bd79fb0.vehicle',
      'namespace' => 'minishop2',
    ),
    66 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '300a66eb7dfec5f34d51c80c7b125d99',
      'native_key' => 'msOnSubmitOrder',
      'filename' => 'modEvent/ba2807206264043300419a2c573c7b9a.vehicle',
      'namespace' => 'minishop2',
    ),
    67 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'b2a9edff981d40c886afa9f6263b92eb',
      'native_key' => 'msOnManagerCustomCssJs',
      'filename' => 'modEvent/e299f6287f175250b54bd8937101303a.vehicle',
      'namespace' => 'minishop2',
    ),
    68 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '0515ca316693ef1896165297ec656126',
      'native_key' => 'msOnBeforeValidateOrderValue',
      'filename' => 'modEvent/38dac4653e086016412bdc1056b90c17.vehicle',
      'namespace' => 'minishop2',
    ),
    69 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'd0fabbbdac4d3f2ea3fd5c6936d3886b',
      'native_key' => 'msOnValidateOrderValue',
      'filename' => 'modEvent/8c907e8f390ac76de58696034b704af8.vehicle',
      'namespace' => 'minishop2',
    ),
    70 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '53e60e23a6d2b9a535c6ac62f796b1a8',
      'native_key' => 'msOnGetProductPrice',
      'filename' => 'modEvent/db95ac681d0d1ae34e4c1fe388586e4d.vehicle',
      'namespace' => 'minishop2',
    ),
    71 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '1315e781b83a50c60f58760e8fdc9ad5',
      'native_key' => 'msOnGetProductWeight',
      'filename' => 'modEvent/12c5be471813d02d55065c6f5bd3aa6c.vehicle',
      'namespace' => 'minishop2',
    ),
    72 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modAccessPolicy',
      'guid' => '9a9ff9a5fbdd8564724262c253926561',
      'native_key' => NULL,
      'filename' => 'modAccessPolicy/718a0904bbef087533b0c6f3a7c42e54.vehicle',
      'namespace' => 'minishop2',
    ),
    73 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modAccessPolicyTemplate',
      'guid' => '40507dfed4663875ef34f4ed05a08d4a',
      'native_key' => NULL,
      'filename' => 'modAccessPolicyTemplate/ea951d5c17ce1e39de1ce82849452a0e.vehicle',
      'namespace' => 'minishop2',
    ),
    74 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modMenu',
      'guid' => '8ed994c4e5cdec6d823ed8991cacd678',
      'native_key' => 'minishop2',
      'filename' => 'modMenu/b6245cd00a2fc3405e112cfad67f30e9.vehicle',
      'namespace' => 'minishop2',
    ),
    75 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modMenu',
      'guid' => '4245351b5fe61c09d2cbc9795dab8372',
      'native_key' => 'ms2_orders',
      'filename' => 'modMenu/419c6d13b177887c0111929e1c36791b.vehicle',
      'namespace' => 'minishop2',
    ),
    76 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modMenu',
      'guid' => '2b9a0c4a6468dc36455b292e77e498a9',
      'native_key' => 'ms2_settings',
      'filename' => 'modMenu/a854546771bb73270d151d0600ccc820.vehicle',
      'namespace' => 'minishop2',
    ),
    77 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modCategory',
      'guid' => '8364fdca011192f5a77283e599c9e965',
      'native_key' => 1,
      'filename' => 'modCategory/9df7fe8178209572038dea25a423c749.vehicle',
      'namespace' => 'minishop2',
    ),
  ),
);