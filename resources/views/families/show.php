<?php
 if (isset($family, $family_members, $summary)) {
	require ROOT_PATH . '/resources/views/families/family-profile/index.php';

} 
else { 
	?><div class="rounded-xl border border-slate-200 bg-white p-8 text-center text-sm text-slate-500">Open a family from the registry to view its profile.</div><?php } ?>