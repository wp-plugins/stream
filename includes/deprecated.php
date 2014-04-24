<?php

/**
 * Handle deprecated filters
 */

global $wp_stream_deprecated_filters;

$wp_stream_deprecated_filters = array(
	array(
		'old'     => 'stream_query_args',
		'new'     => 'wp_stream_query_args',
		'version' => '1.3.2',
	),
	array(
		'old'     => 'stream_toggle_filters',
		'new'     => 'wp_stream_toggle_filters',
		'version' => '1.3.2',
	),
);

foreach ( $wp_stream_deprecated_filters as $filter ) {
	add_filter( $filter['new'], 'wp_stream_deprecated_filter_mapping' );
}

function wp_stream_deprecated_filter_mapping( $data ) {
	global $wp_stream_deprecated_filters;

	$new_filter = current_filter();
	$old_filter = false;
	$version    = false;

	foreach ( $wp_stream_deprecated_filters as $key => $filter ) {
		if ( $new_filter === $filter['new'] ) {
			$old_filter = $filter['old'];
			$version    = $filter['version'];
			break;
		}
	}

	if ( ! $old_filter || ! has_filter( $old_filter ) ) {
		return $data;
	}

	$filter_args = array_merge(
		array(
			$old_filter,
		),
		func_get_args()
	);

	$data = call_user_func_array( 'apply_filters', $filter_args );

	_deprecated_function(
		sprintf( __( 'The %s filter', 'stream' ), $old_filter ),
		$version,
		$new_filter
	);

	return $data;
}

/**
 * stream_query()
 *
 * @deprecated 1.3.2
 * @deprecated Use wp_stream_query()
 * @see wp_stream_query()
 */
function stream_query( $args = array() ) {
	_deprecated_function( __FUNCTION__, '1.3.2', 'wp_stream_query()' );

	return wp_stream_query( $args );
}

/**
 * get_stream_meta()
 *
 * @deprecated 1.3.2
 * @deprecated Use wp_stream_get_meta
 * @see wp_stream_get_meta()
 */
function get_stream_meta( $record_id, $key = '', $single = false ) {
	_deprecated_function( __FUNCTION__, '1.3.2', 'wp_stream_get_meta()' );

	return wp_stream_get_meta( $record_id, $key, $single );
}

/**
 * update_stream_meta()
 *
 * @deprecated 1.3.2
 * @deprecated Use wp_stream_update_meta
 * @see wp_stream_update_meta()
 */
function update_stream_meta( $record_id, $meta_key, $meta_value, $prev_value = '' ) {
	_deprecated_function( __FUNCTION__, '1.3.2', 'wp_stream_update_meta()' );

	return wp_stream_update_meta( $record_id, $meta_key, $meta_value, $prev_value );
}

/**
 * existing_records()
 *
 * @deprecated 1.3.2
 * @deprecated Use wp_stream_existing_records
 * @see wp_stream_existing_records()
 */
function existing_records( $column, $table = '' ) {
	_deprecated_function( __FUNCTION__, '1.3.2', 'wp_stream_existing_records()' );

	return wp_stream_existing_records( $column, $table );
}
