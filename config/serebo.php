<?php

return [
    'status_set_tree' => [
        'design' => json_decode('[{"name":"project_has_been_created","next":[{"name":"stakes","next":[{"name":"digitization","next":[{"name":"drawing","next":[{"name":"schedule","next":[]}]}]},{"name":"drawing","next":[{"name":"digitization","next":[{"name":"schedule","next":[]}]}]},{"name":"returned","next":[{"name":"canceled","next":[]}]}]}]}]', TRUE),
        'rectify_design' => json_decode('[{"name":"rectify_design","next":[{"name":"rd_stakes","next":[{"name":"rd_digitization","next":[{"name":"rd_drawing","next":[]}]},{"name":"rd_drawing","next":[{"name":"rd_digitization","next":[]}]},{"name":"returned","next":[]}]}]}]'),
        'rectify_illustration' => json_decode('[{"name":"rectify_illustration","next":[{"name":"ri_digitization","next":[{"name":"ri_drawing","next":[]}]},{"name":"ri_drawing","next":[{"name":"ri_digitization","next":[]}]}]}]'),
        'approvement' => json_decode('[{"name":"ready_to_send","next":[{"name":"already_sent","next":[{"name":"approved","next":[{"name":"canceled","next":[]}]},{"name":"canceled","next":[]},{"name":"rectify_design","next":[]},{"name":"rectify_illustration","next":[]}]}]}]'),
        'building' => json_decode('[{"name":"assign_to","next":[{"name":"in_progress","next":[{"name":"paused","next":[{"name":"completed","next":[{"name":"project_energized","next":[{"name":"as_built","next":[{"name":"conciliation_reception","next":[{"name":"conciliation_shipment","next":[{"name":"cre_return_order","next":[{"name":"project_return_materials","next":[]}]}]}]}]}]},{"name":"as_built","next":[{"name":"project_energized","next":[{"name":"conciliation_reception","next":[{"name":"conciliation_shipment","next":[{"name":"cre_return_order","next":[{"name":"project_return_materials","next":[]}]}]}]}]}]}]},{"name":"stopped","next":[{"name":"as_built","next":[{"name":"conciliation_reception","next":[{"name":"conciliation_shipment","next":[{"name":"cre_return_order","next":[{"name":"project_return_materials","next":[]}]}]}]}]}]}]},{"name":"completed","next":[{"name":"project_energized","next":[{"name":"as_built","next":[{"name":"conciliation_reception","next":[{"name":"conciliation_shipment","next":[{"name":"cre_return_order","next":[{"name":"project_return_materials","next":[]}]}]}]}]}]},{"name":"as_built","next":[{"name":"project_energized","next":[{"name":"conciliation_reception","next":[{"name":"conciliation_shipment","next":[{"name":"cre_return_order","next":[{"name":"project_return_materials","next":[]}]}]}]}]}]}]}]}]}]')
    ],
    'status_set_list' => [
        'design' => [
            'project_has_been_created',
            'stakes',
            'digitization',
            'drawing',
            'schedule',
            'returned',
            'canceled'
        ],
        'rectify_design' => [
            'rectify_design',
            'rd_stakes',
            'rd_digitization',
            'rd_drawing',
            'returned'
        ],
        'rectify_illustration' => [
            'rectify_illustration',
            'ri_digitization',
            'ri_drawing',
            'ri_drawing',
            'ri_digitization'
        ],
        'approvement' => [
            'ready_to_send',
            'already_sent',
            'approved',
            'canceled',
            'rectify_design',
            'rectify_illustration'
        ],
        'building' => [
            "assign_to",
            "in_progress",
            "paused",
            "completed",
            "project_energized",
            "as_built",
            "conciliation_reception",
            "conciliation_shipment",
            "cre_return_order",
            "project_return_materials",
            "stopped",
        ],
    ]
];
