<?php
/**
 * Google Fonts Class file
 *
 * @package WordPress
 * @subpackage Visual Composer Starter
 * @since Visual Composer Starter 1.0
 */

/**
 * Class VisualComposerStarter_Fonts
 */
class VisualComposerStarter_Fonts {

	/**
	 * Relative path to fonts subdirectory
	 */
	const PATH_TO_LOCAL_FONTS = 'visual-composer-starter/fonts';

	/**
	 * Current font id
	 *
	 * Required for dynamically determining the subdirectory in uploads folder.
	 *
	 * @var string
	 */
	public static $font_id = '';

    public static $filter_type = 'mime_types';

	/**
	 * Get Fonts List
	 *
	 * @return array
	 */
	protected static function vct_get_fonts_list() {
		$heading1 = array(
			1 => array(
				'label' => sprintf( '--- %s ---', esc_html__( 'Standard Fonts', 'visual-composer-starter' ) ),
			),
		);
		$standard_fonts = self::vct_theme_standard_fonts();
		$heading2 = array(
			2 => array(
				'label' => sprintf( '--- %s ---', esc_html__( 'Google Fonts', 'visual-composer-starter' ) ),
			),
		);
		$google_fonts = self::vct_theme_google_fonts();
		return array_merge( $heading1, $standard_fonts, $heading2, $google_fonts );
	}

	/**
	 * Theme standard fonts list
	 *
	 * @return array
	 */
	protected static function vct_theme_standard_fonts() {
		return array(
			'Arial, Helvetica, sans-serif' => array(
				'label' => _x( 'Arial, Helvetica, sans-serif', 'font style', 'visual-composer-starter' ),
				'stack' => 'Arial, Helvetica, sans-serif',
			),
			"'Arial Black', Gadget, sans-serif" => array(
				'label' => _x( 'Arial Black, Gadget, sans-serif', 'font style', 'visual-composer-starter' ),
				'stack' => "'Arial Black', Gadget, sans-serif",
			),
			"'Bookman Old Style', serif" => array(
				'label' => _x( 'Bookman Old Style, serif', 'font style', 'visual-composer-starter' ),
				'stack' => "'Bookman Old Style', serif",
			),
			"'Comic Sans MS', cursive" => array(
				'label' => _x( 'Comic Sans MS, cursive', 'font style', 'visual-composer-starter' ),
				'stack' => "'Comic Sans MS', cursive",
			),
			'Courier, monospace' => array(
				'label' => _x( 'Courier, monospace', 'font style', 'visual-composer-starter' ),
				'stack' => 'Courier, monospace',
			),
			'Garamond, serif' => array(
				'label' => _x( 'Garamond, serif', 'font style', 'visual-composer-starter' ),
				'stack' => 'Garamond, serif',
			),
			'Georgia, serif' => array(
				'label' => _x( 'Georgia, serif', 'font style', 'visual-composer-starter' ),
				'stack' => 'Georgia, serif',
			),
			'Impact, Charcoal, sans-serif' => array(
				'label' => _x( 'Impact, Charcoal, sans-serif', 'font style', 'visual-composer-starter' ),
				'stack' => 'Impact, Charcoal, sans-serif',
			),
			"'Lucida Console', Monaco, monospace" => array(
				'label' => _x( 'Lucida Console, Monaco, monospace', 'font style', 'visual-composer-starter' ),
				'stack' => "'Lucida Console', Monaco, monospace",
			),
			"'Lucida Sans Unicode', 'Lucida Grande', sans-serif" => array(
				'label' => _x( 'Lucida Sans Unicode, Lucida Grande, sans-serif', 'font style', 'visual-composer-starter' ),
				'stack' => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
			),
			"'MS Sans Serif', Geneva, sans-serif" => array(
				'label' => _x( 'MS Sans Serif, Geneva, sans-serif', 'font style', 'visual-composer-starter' ),
				'stack' => "'MS Sans Serif', Geneva, sans-serif",
			),
			"'MS Serif', 'New York', sans-serif" => array(
				'label' => _x( 'MS Serif, New York, sans-serif', 'font style', 'visual-composer-starter' ),
				'stack' => "'MS Serif', 'New York', sans-serif",
			),
			"'Palatino Linotype', 'Book Antiqua', Palatino, serif" => array(
				'label' => _x( 'Palatino Linotype, Book Antiqua, Palatino, serif', 'font style', 'visual-composer-starter' ),
				'stack' => "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
			),
			'Tahoma, Geneva, sans-serif' => array(
				'label' => _x( 'Tahoma, Geneva, sans-serif', 'font style', 'visual-composer-starter' ),
				'stack' => 'Tahoma, Geneva, sans-serif',
			),
			"'Times New Roman', Times, serif" => array(
				'label' => _x( 'Times New Roman, Times, serif', 'font style', 'visual-composer-starter' ),
				'stack' => "'Times New Roman', Times, serif",
			),
			"'Trebuchet MS', Helvetica, sans-serif" => array(
				'label' => _x( 'Trebuchet MS, Helvetica, sans-serif', 'font style', 'visual-composer-starter' ),
				'stack' => "'Trebuchet MS', Helvetica, sans-serif",
			),
			'Verdana, Geneva, sans-serif' => array(
				'label' => _x( 'Verdana, Geneva, sans-serif', 'font style', 'visual-composer-starter' ),
				'stack' => 'Verdana, Geneva, sans-serif',
			),

		);
	}

	/**
	 * Theme font choices
	 *
	 * @return array
	 */
	public static function vct_theme_font_choices() {
		$fonts  = self::vct_get_fonts_list();
		$choices = array();

		foreach ( $fonts as $key => $font ) {
			$choices[ $key ] = $font['label'];
		}

		return $choices;
	}

	/**
	 * Get Google font uri
	 *
	 * @param array $fonts Fonts array.
	 *
	 * @return string
	 */
	public static function vct_theme_get_google_font_uri( $fonts ) {

		// De-dupe the fonts.
		$fonts     = array_unique( $fonts );
		$allowed_fonts = self::vct_theme_google_fonts();
		$family    = array();

		// The theme stylesheets load fonts "Roboto" and "Montserrat".
		$fonts = array_diff( $fonts, array( 'Roboto', 'Roboto, sans-serif', 'Montserrat' ) );

		// Validate each font and convert to URL format.
		foreach ( $fonts as $font ) {
			$font = trim( $font );

			// Verify that the font exists.
			if ( array_key_exists( $font, $allowed_fonts ) || array_key_exists( $font . ', sans-serif', $allowed_fonts ) ) {
				if ( array_key_exists( $font . ', sans-serif', $allowed_fonts ) ) {
					$font = $font . ', sans-serif';
				}
				$font_full_name = $font;
				$font_array = explode( ',', $font );
				$font = $font_array[0];
				$font = trim( $font );
				// Build the family name and variant string (e.g., "Open+Sans:regular,italic,700").
				$family[] = urlencode( $font . ':' . join( ',', self::vct_theme_google_font_variants( $font, $allowed_fonts[ $font_full_name ]['variants'] ) ) );
			}
		}

		// Convert from array to string.
		if ( empty( $family ) ) {
			return '';
		} else {
			$request = '//fonts.googleapis.com/css?family=' . implode( '|', $family );
		}

		// Load the font subset.
		$subset = get_theme_mod( 'vct_fonts_and_style_subsets', 'all' );

		if ( 'all' === $subset ) {
			$subsets_available = self::vct_theme_font_subsets();

			unset( $subsets_available['all'] );

			$subsets = array_keys( $subsets_available );
		} else {
			$subsets = array(
				'latin',
				$subset,
			);
		}

		// Append the subset string.
		if ( ! empty( $subsets ) ) {
			$request .= urlencode( '&subset=' . join( ',', $subsets ) );
		}

		return esc_url( $request );
	}

	/**
	 * Font subsets
	 *
	 * @return array
	 */
	public static function vct_theme_font_subsets() {
		return array(
			'all'     => esc_html__( 'All', 'visual-composer-starter' ),
			'cyrillic'   => esc_html__( 'Cyrillic', 'visual-composer-starter' ),
			'cyrillic-ext' => esc_html__( 'Cyrillic Extended', 'visual-composer-starter' ),
			'devanagari'  => esc_html__( 'Devanagari', 'visual-composer-starter' ),
			'greek'    => esc_html__( 'Greek', 'visual-composer-starter' ),
			'greek-ext'  => esc_html__( 'Greek Extended', 'visual-composer-starter' ),
			'khmer'    => esc_html__( 'Khmer', 'visual-composer-starter' ),
			'latin'    => esc_html__( 'Latin', 'visual-composer-starter' ),
			'latin-ext'  => esc_html__( 'Latin Extended', 'visual-composer-starter' ),
			'vietnamese'  => esc_html__( 'Vietnamese', 'visual-composer-starter' ),
		);
	}

	/**
	 * Google font variants
	 *
	 * @param string $font Font name.
	 * @param array  $variants Font variants.
	 *
	 * @return array
	 */
	public static function vct_theme_google_font_variants( $font, $variants = array() ) {
		$chosen_variants = array();
		if ( empty( $variants ) ) {
			$fonts = self::vct_theme_google_fonts();

			if ( array_key_exists( $font, $fonts ) ) {
				$variants = $fonts[ $font ]['variants'];
			}
		}

		// If a "regular" variant is not found, get the first variant.
		if ( ! in_array( 'regular', $variants ) ) {
			$chosen_variants[] = $variants[0];
		} else {
			$chosen_variants[] = 'regular';
		}

		// Only add "italic" if it exists.
		if ( in_array( 'italic', $variants ) ) {
			$chosen_variants[] = 'italic';
		}

		// Font weights.
		$font_types = array( 'body', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'buttons' );

		foreach ( $font_types as $font_type ) {
			$font_family = get_theme_mod( 'vct_fonts_and_style_' . $font_type . '_font_family' );
			if ( $font_family === $font ) {
				$font_weight = get_theme_mod( 'vct_fonts_and_style_' . $font_type . '_weight', '400' );

				if ( in_array( $font_weight, $variants ) ) {
					$chosen_variants[] = $font_weight;
				}
			}
		}

		return array_unique( $chosen_variants );
	}

	/**
	 * Google Fonts list
	 *
	 * @return mixed
	 */
	protected static function vct_theme_google_fonts() {
		return apply_filters( 'vct_theme_google_fonts_list', array(
			'ABeeZee, sans-serif' => array(
				'label'  => 'ABeeZee, sans-serif',
				'variants' => array(
					'regular',
					'italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Abel, sans-serif' => array(
				'label'  => 'Abel, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Abril Fatface, cursive' => array(
				'label'  => 'Abril Fatface, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Aclonica, sans-serif' => array(
				'label'  => 'Aclonica, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Acme, sans-serif' => array(
				'label'  => 'Acme, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Actor, sans-serif' => array(
				'label'  => 'Actor, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Adamina, sans-serif' => array(
				'label'  => 'Adamina, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Advent Pro, sans-serif' => array(
				'label'  => 'Advent Pro, sans-serif',
				'variants' => array(
					'100',
					'200',
					'300',
					'regular',
					'500',
					'600',
					'700',
				),
				'subsets' => array(
					'latin',
					'greek',
					'latin-ext',
				),
			),
			'Aguafina Script, cursive' => array(
				'label'  => 'Aguafina Script, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Akronim, cursive' => array(
				'label'  => 'Akronim, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Aladin, cursive' => array(
				'label'  => 'Aladin, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Aldrich, sans-serif' => array(
				'label'  => 'Aldrich, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Alef, sans-serif' => array(
				'label'  => 'Alef, sans-serif',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Alegreya, sans-serif' => array(
				'label'  => 'Alegreya, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
					'900',
					'900italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Alegreya SC, sans-serif' => array(
				'label'  => 'Alegreya SC, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
					'900',
					'900italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Alegreya Sans, sans-serif' => array(
				'label'  => 'Alegreya Sans, sans-serif',
				'variants' => array(
					'100',
					'100italic',
					'300',
					'300italic',
					'regular',
					'italic',
					'500',
					'500italic',
					'700',
					'700italic',
					'800',
					'800italic',
					'900',
					'900italic',
				),
				'subsets' => array(
					'latin',
					'vietnamese',
					'latin-ext',
				),
			),
			'Alegreya Sans SC, sans-serif' => array(
				'label'  => 'Alegreya Sans SC, sans-serif',
				'variants' => array(
					'100',
					'100italic',
					'300',
					'300italic',
					'regular',
					'italic',
					'500',
					'500italic',
					'700',
					'700italic',
					'800',
					'800italic',
					'900',
					'900italic',
				),
				'subsets' => array(
					'latin',
					'vietnamese',
					'latin-ext',
				),
			),
			'Alex Brush, cursive' => array(
				'label'  => 'Alex Brush, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Alfa Slab One, cursive' => array(
				'label'  => 'Alfa Slab One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Alice, sans-serif' => array(
				'label'  => 'Alice, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Alike, sans-serif' => array(
				'label'  => 'Alike, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Alike Angular, sans-serif' => array(
				'label'  => 'Alike Angular, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Allan, cursive' => array(
				'label'  => 'Allan, cursive',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Allerta, sans-serif' => array(
				'label'  => 'Allerta, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Allerta Stencil, sans-serif' => array(
				'label'  => 'Allerta Stencil, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Allura, cursive' => array(
				'label'  => 'Allura, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Almendra, sans-serif' => array(
				'label'  => 'Almendra, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Almendra Display, sans-serif' => array(
				'label'  => 'Almendra Display, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Almendra SC, sans-serif' => array(
				'label'  => 'Almendra SC, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Amarante, cursive' => array(
				'label'  => 'Amarante, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Amaranth, sans-serif' => array(
				'label'  => 'Amaranth, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Amatic SC, cursive' => array(
				'label'  => 'Amatic SC, cursive',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Amethysta, sans-serif' => array(
				'label'  => 'Amethysta, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Anaheim, sans-serif' => array(
				'label'  => 'Anaheim, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Andada, sans-serif' => array(
				'label'  => 'Andada, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Andika, sans-serif' => array(
				'label'  => 'Andika, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Angkor, cursive' => array(
				'label'  => 'Angkor, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'khmer',
				),
			),
			'Annie Use Your Telescope, cursive' => array(
				'label'  => 'Annie Use Your Telescope, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Anonymous Pro, monospace' => array(
				'label'  => 'Anonymous Pro, monospace',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'greek-ext',
					'cyrillic',
					'greek',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Antic, sans-serif' => array(
				'label'  => 'Antic, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Antic Didone, sans-serif' => array(
				'label'  => 'Antic Didone, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Antic Slab, sans-serif' => array(
				'label'  => 'Antic Slab, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Anton, sans-serif' => array(
				'label'  => 'Anton, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Arapey, sans-serif' => array(
				'label'  => 'Arapey, sans-serif',
				'variants' => array(
					'regular',
					'italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Arbutus, cursive' => array(
				'label'  => 'Arbutus, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Arbutus Slab, sans-serif' => array(
				'label'  => 'Arbutus Slab, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Architects Daughter, cursive' => array(
				'label'  => 'Architects Daughter, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Archivo Black, sans-serif' => array(
				'label'  => 'Archivo Black, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Archivo Narrow, sans-serif' => array(
				'label'  => 'Archivo Narrow, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Arimo, sans-serif' => array(
				'label'  => 'Arimo, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'greek-ext',
					'cyrillic',
					'greek',
					'vietnamese',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Arizonia, cursive' => array(
				'label'  => 'Arizonia, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Armata, sans-serif' => array(
				'label'  => 'Armata, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Artifika, sans-serif' => array(
				'label'  => 'Artifika, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Arvo, sans-serif' => array(
				'label'  => 'Arvo, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Asap, sans-serif' => array(
				'label'  => 'Asap, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Asset, cursive' => array(
				'label'  => 'Asset, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Astloch, cursive' => array(
				'label'  => 'Astloch, cursive',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Asul, sans-serif' => array(
				'label'  => 'Asul, sans-serif',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Atomic Age, cursive' => array(
				'label'  => 'Atomic Age, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Aubrey, cursive' => array(
				'label'  => 'Aubrey, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Audiowide, cursive' => array(
				'label'  => 'Audiowide, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Autour One, cursive' => array(
				'label'  => 'Autour One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Average, sans-serif' => array(
				'label'  => 'Average, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Average Sans, sans-serif' => array(
				'label'  => 'Average Sans, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Averia Gruesa Libre, cursive' => array(
				'label'  => 'Averia Gruesa Libre, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Averia Libre, cursive' => array(
				'label'  => 'Averia Libre, cursive',
				'variants' => array(
					'300',
					'300italic',
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Averia Sans Libre, cursive' => array(
				'label'  => 'Averia Sans Libre, cursive',
				'variants' => array(
					'300',
					'300italic',
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Averia Serif Libre, cursive' => array(
				'label'  => 'Averia Serif Libre, cursive',
				'variants' => array(
					'300',
					'300italic',
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Bad Script, cursive' => array(
				'label'  => 'Bad Script, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
				),
			),
			'Balthazar, sans-serif' => array(
				'label'  => 'Balthazar, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Bangers, cursive' => array(
				'label'  => 'Bangers, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Basic, sans-serif' => array(
				'label'  => 'Basic, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Battambang, cursive' => array(
				'label'  => 'Battambang, cursive',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'khmer',
				),
			),
			'Baumans, cursive' => array(
				'label'  => 'Baumans, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Bayon, cursive' => array(
				'label'  => 'Bayon, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'khmer',
				),
			),
			'Belgrano, sans-serif' => array(
				'label'  => 'Belgrano, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Belleza, sans-serif' => array(
				'label'  => 'Belleza, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'BenchNine, sans-serif' => array(
				'label'  => 'BenchNine, sans-serif',
				'variants' => array(
					'300',
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Bentham, sans-serif' => array(
				'label'  => 'Bentham, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Berkshire Swash, cursive' => array(
				'label'  => 'Berkshire Swash, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Bevan, cursive' => array(
				'label'  => 'Bevan, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Bigelow Rules, cursive' => array(
				'label'  => 'Bigelow Rules, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Bigshot One, cursive' => array(
				'label'  => 'Bigshot One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Bilbo, cursive' => array(
				'label'  => 'Bilbo, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Bilbo Swash Caps, cursive' => array(
				'label'  => 'Bilbo Swash Caps, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Bitter, sans-serif' => array(
				'label'  => 'Bitter, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Black Ops One, cursive' => array(
				'label'  => 'Black Ops One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Bokor, cursive' => array(
				'label'  => 'Bokor, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'khmer',
				),
			),
			'Bonbon, cursive' => array(
				'label'  => 'Bonbon, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Boogaloo, cursive' => array(
				'label'  => 'Boogaloo, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Bowlby One, cursive' => array(
				'label'  => 'Bowlby One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Bowlby One SC, cursive' => array(
				'label'  => 'Bowlby One SC, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Brawler, sans-serif' => array(
				'label'  => 'Brawler, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Bree Serif, sans-serif' => array(
				'label'  => 'Bree Serif, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Bubblegum Sans, cursive' => array(
				'label'  => 'Bubblegum Sans, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Bubbler One, sans-serif' => array(
				'label'  => 'Bubbler One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Buda, cursive' => array(
				'label'  => 'Buda, cursive',
				'variants' => array(
					'300',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Buenard, sans-serif' => array(
				'label'  => 'Buenard, sans-serif',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Butcherman, cursive' => array(
				'label'  => 'Butcherman, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Butterfly Kids, cursive' => array(
				'label'  => 'Butterfly Kids, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Cabin, sans-serif' => array(
				'label'  => 'Cabin, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'500',
					'500italic',
					'600',
					'600italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Cabin Condensed, sans-serif' => array(
				'label'  => 'Cabin Condensed, sans-serif',
				'variants' => array(
					'regular',
					'500',
					'600',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Cabin Sketch, cursive' => array(
				'label'  => 'Cabin Sketch, cursive',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Caesar Dressing, cursive' => array(
				'label'  => 'Caesar Dressing, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Cagliostro, sans-serif' => array(
				'label'  => 'Cagliostro, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Calligraffitti, cursive' => array(
				'label'  => 'Calligraffitti, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Cambo, sans-serif' => array(
				'label'  => 'Cambo, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Candal, sans-serif' => array(
				'label'  => 'Candal, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Cantarell, sans-serif' => array(
				'label'  => 'Cantarell, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Cantata One, sans-serif' => array(
				'label'  => 'Cantata One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Cantora One, sans-serif' => array(
				'label'  => 'Cantora One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Capriola, sans-serif' => array(
				'label'  => 'Capriola, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Cardo, sans-serif' => array(
				'label'  => 'Cardo, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
				),
				'subsets' => array(
					'latin',
					'greek-ext',
					'greek',
					'latin-ext',
				),
			),
			'Carme, sans-serif' => array(
				'label'  => 'Carme, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Carrois Gothic, sans-serif' => array(
				'label'  => 'Carrois Gothic, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Carrois Gothic SC, sans-serif' => array(
				'label'  => 'Carrois Gothic SC, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Carter One, cursive' => array(
				'label'  => 'Carter One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Caudex, sans-serif' => array(
				'label'  => 'Caudex, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'greek-ext',
					'greek',
					'latin-ext',
				),
			),
			'Cedarville Cursive, cursive' => array(
				'label'  => 'Cedarville Cursive, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Ceviche One, cursive' => array(
				'label'  => 'Ceviche One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Changa One, cursive' => array(
				'label'  => 'Changa One, cursive',
				'variants' => array(
					'regular',
					'italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Chango, cursive' => array(
				'label'  => 'Chango, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Chau Philomene One, sans-serif' => array(
				'label'  => 'Chau Philomene One, sans-serif',
				'variants' => array(
					'regular',
					'italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Chela One, cursive' => array(
				'label'  => 'Chela One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Chelsea Market, cursive' => array(
				'label'  => 'Chelsea Market, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Chenla, cursive' => array(
				'label'  => 'Chenla, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'khmer',
				),
			),
			'Cherry Cream Soda, cursive' => array(
				'label'  => 'Cherry Cream Soda, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Cherry Swash, cursive' => array(
				'label'  => 'Cherry Swash, cursive',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Chewy, cursive' => array(
				'label'  => 'Chewy, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Chicle, cursive' => array(
				'label'  => 'Chicle, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Chivo, sans-serif' => array(
				'label'  => 'Chivo, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'900',
					'900italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Cinzel, sans-serif' => array(
				'label'  => 'Cinzel, sans-serif',
				'variants' => array(
					'regular',
					'700',
					'900',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Cinzel Decorative, cursive' => array(
				'label'  => 'Cinzel Decorative, cursive',
				'variants' => array(
					'regular',
					'700',
					'900',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Clicker Script, cursive' => array(
				'label'  => 'Clicker Script, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Coda, cursive' => array(
				'label'  => 'Coda, cursive',
				'variants' => array(
					'regular',
					'800',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Coda Caption, sans-serif' => array(
				'label'  => 'Coda Caption, sans-serif',
				'variants' => array(
					'800',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Codystar, cursive' => array(
				'label'  => 'Codystar, cursive',
				'variants' => array(
					'300',
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Combo, cursive' => array(
				'label'  => 'Combo, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Comfortaa, cursive' => array(
				'label'  => 'Comfortaa, cursive',
				'variants' => array(
					'300',
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'greek',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Coming Soon, cursive' => array(
				'label'  => 'Coming Soon, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Concert One, cursive' => array(
				'label'  => 'Concert One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Condiment, cursive' => array(
				'label'  => 'Condiment, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Content, cursive' => array(
				'label'  => 'Content, cursive',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'khmer',
				),
			),
			'Contrail One, cursive' => array(
				'label'  => 'Contrail One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Convergence, sans-serif' => array(
				'label'  => 'Convergence, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Cookie, cursive' => array(
				'label'  => 'Cookie, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Copse, sans-serif' => array(
				'label'  => 'Copse, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Corben, cursive' => array(
				'label'  => 'Corben, cursive',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Courgette, cursive' => array(
				'label'  => 'Courgette, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Cousine, monospace' => array(
				'label'  => 'Cousine, monospace',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'greek-ext',
					'cyrillic',
					'greek',
					'vietnamese',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Coustard, sans-serif' => array(
				'label'  => 'Coustard, sans-serif',
				'variants' => array(
					'regular',
					'900',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Covered By Your Grace, cursive' => array(
				'label'  => 'Covered By Your Grace, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Crafty Girls, cursive' => array(
				'label'  => 'Crafty Girls, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Creepster, cursive' => array(
				'label'  => 'Creepster, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Crete Round, sans-serif' => array(
				'label'  => 'Crete Round, sans-serif',
				'variants' => array(
					'regular',
					'italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Crimson Text, sans-serif' => array(
				'label'  => 'Crimson Text, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'600',
					'600italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Croissant One, cursive' => array(
				'label'  => 'Croissant One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Crushed, cursive' => array(
				'label'  => 'Crushed, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Cuprum, sans-serif' => array(
				'label'  => 'Cuprum, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
				),
			),
			'Cutive, sans-serif' => array(
				'label'  => 'Cutive, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Cutive Mono, monospace' => array(
				'label'  => 'Cutive Mono, monospace',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Damion, cursive' => array(
				'label'  => 'Damion, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Dancing Script, cursive' => array(
				'label'  => 'Dancing Script, cursive',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Dangrek, cursive' => array(
				'label'  => 'Dangrek, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'khmer',
				),
			),
			'Dawning of a New Day, cursive' => array(
				'label'  => 'Dawning of a New Day, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Days One, sans-serif' => array(
				'label'  => 'Days One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Delius, cursive' => array(
				'label'  => 'Delius, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Delius Swash Caps, cursive' => array(
				'label'  => 'Delius Swash Caps, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Delius Unicase, cursive' => array(
				'label'  => 'Delius Unicase, cursive',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Della Respira, sans-serif' => array(
				'label'  => 'Della Respira, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Denk One, sans-serif' => array(
				'label'  => 'Denk One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Devonshire, cursive' => array(
				'label'  => 'Devonshire, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Didact Gothic, sans-serif' => array(
				'label'  => 'Didact Gothic, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'greek-ext',
					'cyrillic',
					'greek',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Diplomata, cursive' => array(
				'label'  => 'Diplomata, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Diplomata SC, cursive' => array(
				'label'  => 'Diplomata SC, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Domine, sans-serif' => array(
				'label'  => 'Domine, sans-serif',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Donegal One, sans-serif' => array(
				'label'  => 'Donegal One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Doppio One, sans-serif' => array(
				'label'  => 'Doppio One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Dorsa, sans-serif' => array(
				'label'  => 'Dorsa, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Dosis, sans-serif' => array(
				'label'  => 'Dosis, sans-serif',
				'variants' => array(
					'200',
					'300',
					'regular',
					'500',
					'600',
					'700',
					'800',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Dr Sugiyama, cursive' => array(
				'label'  => 'Dr Sugiyama, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Droid Sans, sans-serif' => array(
				'label'  => 'Droid Sans, sans-serif',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Droid Sans Mono, sans-serif' => array(
				'label'  => 'Droid Sans Mono, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Droid Serif, sans-serif' => array(
				'label'  => 'Droid Serif, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Duru Sans, sans-serif' => array(
				'label'  => 'Duru Sans, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Dynalight, cursive' => array(
				'label'  => 'Dynalight, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'EB Garamond, sans-serif' => array(
				'label'  => 'EB Garamond, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'vietnamese',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Eagle Lake, cursive' => array(
				'label'  => 'Eagle Lake, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Eater, cursive' => array(
				'label'  => 'Eater, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Economica, sans-serif' => array(
				'label'  => 'Economica, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Electrolize, sans-serif' => array(
				'label'  => 'Electrolize, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Elsie, cursive' => array(
				'label'  => 'Elsie, cursive',
				'variants' => array(
					'regular',
					'900',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Elsie Swash Caps, cursive' => array(
				'label'  => 'Elsie Swash Caps, cursive',
				'variants' => array(
					'regular',
					'900',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Emblema One, cursive' => array(
				'label'  => 'Emblema One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Emilys Candy, cursive' => array(
				'label'  => 'Emilys Candy, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Engagement, cursive' => array(
				'label'  => 'Engagement, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Englebert, sans-serif' => array(
				'label'  => 'Englebert, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Enriqueta, sans-serif' => array(
				'label'  => 'Enriqueta, sans-serif',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Erica One, cursive' => array(
				'label'  => 'Erica One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Esteban, sans-serif' => array(
				'label'  => 'Esteban, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Euphoria Script, cursive' => array(
				'label'  => 'Euphoria Script, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Ewert, cursive' => array(
				'label'  => 'Ewert, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Exo, sans-serif' => array(
				'label'  => 'Exo, sans-serif',
				'variants' => array(
					'100',
					'100italic',
					'200',
					'200italic',
					'300',
					'300italic',
					'regular',
					'italic',
					'500',
					'500italic',
					'600',
					'600italic',
					'700',
					'700italic',
					'800',
					'800italic',
					'900',
					'900italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Exo 2, sans-serif' => array(
				'label'  => 'Exo 2, sans-serif',
				'variants' => array(
					'100',
					'100italic',
					'200',
					'200italic',
					'300',
					'300italic',
					'regular',
					'italic',
					'500',
					'500italic',
					'600',
					'600italic',
					'700',
					'700italic',
					'800',
					'800italic',
					'900',
					'900italic',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
				),
			),
			'Expletus Sans, cursive' => array(
				'label'  => 'Expletus Sans, cursive',
				'variants' => array(
					'regular',
					'italic',
					'500',
					'500italic',
					'600',
					'600italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Fanwood Text, sans-serif' => array(
				'label'  => 'Fanwood Text, sans-serif',
				'variants' => array(
					'regular',
					'italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Fascinate, cursive' => array(
				'label'  => 'Fascinate, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Fascinate Inline, cursive' => array(
				'label'  => 'Fascinate Inline, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Faster One, cursive' => array(
				'label'  => 'Faster One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Fasthand, sans-serif' => array(
				'label'  => 'Fasthand, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'khmer',
				),
			),
			'Fauna One, sans-serif' => array(
				'label'  => 'Fauna One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Federant, cursive' => array(
				'label'  => 'Federant, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Federo, sans-serif' => array(
				'label'  => 'Federo, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Felipa, cursive' => array(
				'label'  => 'Felipa, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Fenix, sans-serif' => array(
				'label'  => 'Fenix, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Finger Paint, cursive' => array(
				'label'  => 'Finger Paint, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Fira Sans, sans-serif' => array(
				'label'  => 'Fira Sans, sans-serif',
				'variants' => array(
					'300',
					'300italic',
					'400',
					'400italic',
					'500',
					'500italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'greek',
					'cyrillic',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Fira Mono, monospace' => array(
				'label'  => 'Fira Mono, monospace',
				'variants' => array(
					'400',
					'700',
				),
				'subsets' => array(
					'latin',
					'greek',
					'cyrillic',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Fjalla One, sans-serif' => array(
				'label'  => 'Fjalla One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Fjord One, sans-serif' => array(
				'label'  => 'Fjord One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Flamenco, cursive' => array(
				'label'  => 'Flamenco, cursive',
				'variants' => array(
					'300',
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Flavors, cursive' => array(
				'label'  => 'Flavors, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Fondamento, cursive' => array(
				'label'  => 'Fondamento, cursive',
				'variants' => array(
					'regular',
					'italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Fontdiner Swanky, cursive' => array(
				'label'  => 'Fontdiner Swanky, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Forum, cursive' => array(
				'label'  => 'Forum, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Francois One, sans-serif' => array(
				'label'  => 'Francois One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Freckle Face, cursive' => array(
				'label'  => 'Freckle Face, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Fredericka the Great, cursive' => array(
				'label'  => 'Fredericka the Great, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Fredoka One, cursive' => array(
				'label'  => 'Fredoka One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Freehand, cursive' => array(
				'label'  => 'Freehand, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'khmer',
				),
			),
			'Fresca, sans-serif' => array(
				'label'  => 'Fresca, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Frijole, cursive' => array(
				'label'  => 'Frijole, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Fruktur, cursive' => array(
				'label'  => 'Fruktur, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Fugaz One, cursive' => array(
				'label'  => 'Fugaz One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'GFS Didot, sans-serif' => array(
				'label'  => 'GFS Didot, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'greek',
				),
			),
			'GFS Neohellenic, sans-serif' => array(
				'label'  => 'GFS Neohellenic, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'greek',
				),
			),
			'Gabriela, sans-serif' => array(
				'label'  => 'Gabriela, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Gafata, sans-serif' => array(
				'label'  => 'Gafata, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Galdeano, sans-serif' => array(
				'label'  => 'Galdeano, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Galindo, cursive' => array(
				'label'  => 'Galindo, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Gentium Basic, sans-serif' => array(
				'label'  => 'Gentium Basic, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Gentium Book Basic, sans-serif' => array(
				'label'  => 'Gentium Book Basic, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Geo, sans-serif' => array(
				'label'  => 'Geo, sans-serif',
				'variants' => array(
					'regular',
					'italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Geostar, cursive' => array(
				'label'  => 'Geostar, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Geostar Fill, cursive' => array(
				'label'  => 'Geostar Fill, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Germania One, cursive' => array(
				'label'  => 'Germania One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Gilda Display, sans-serif' => array(
				'label'  => 'Gilda Display, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Give You Glory, cursive' => array(
				'label'  => 'Give You Glory, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Glass Antiqua, cursive' => array(
				'label'  => 'Glass Antiqua, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Glegoo, sans-serif' => array(
				'label'  => 'Glegoo, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Gloria Hallelujah, cursive' => array(
				'label'  => 'Gloria Hallelujah, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Goblin One, cursive' => array(
				'label'  => 'Goblin One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Gochi Hand, cursive' => array(
				'label'  => 'Gochi Hand, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Gorditas, cursive' => array(
				'label'  => 'Gorditas, cursive',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Goudy Bookletter 1911, sans-serif' => array(
				'label'  => 'Goudy Bookletter 1911, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Graduate, cursive' => array(
				'label'  => 'Graduate, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Grand Hotel, cursive' => array(
				'label'  => 'Grand Hotel, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Gravitas One, cursive' => array(
				'label'  => 'Gravitas One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Great Vibes, cursive' => array(
				'label'  => 'Great Vibes, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Griffy, cursive' => array(
				'label'  => 'Griffy, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Gruppo, cursive' => array(
				'label'  => 'Gruppo, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Gudea, sans-serif' => array(
				'label'  => 'Gudea, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Habibi, sans-serif' => array(
				'label'  => 'Habibi, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Hammersmith One, sans-serif' => array(
				'label'  => 'Hammersmith One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Hanalei, cursive' => array(
				'label'  => 'Hanalei, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Hanalei Fill, cursive' => array(
				'label'  => 'Hanalei Fill, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Handlee, cursive' => array(
				'label'  => 'Handlee, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Hanuman, sans-serif' => array(
				'label'  => 'Hanuman, sans-serif',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'khmer',
				),
			),
			'Happy Monkey, cursive' => array(
				'label'  => 'Happy Monkey, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Headland One, sans-serif' => array(
				'label'  => 'Headland One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Henny Penny, cursive' => array(
				'label'  => 'Henny Penny, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Herr Von Muellerhoff, cursive' => array(
				'label'  => 'Herr Von Muellerhoff, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Holtwood One SC, sans-serif' => array(
				'label'  => 'Holtwood One SC, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Homemade Apple, cursive' => array(
				'label'  => 'Homemade Apple, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Homenaje, sans-serif' => array(
				'label'  => 'Homenaje, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'IM Fell DW Pica, sans-serif' => array(
				'label'  => 'IM Fell DW Pica, sans-serif',
				'variants' => array(
					'regular',
					'italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'IM Fell DW Pica SC, sans-serif' => array(
				'label'  => 'IM Fell DW Pica SC, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'IM Fell Double Pica, sans-serif' => array(
				'label'  => 'IM Fell Double Pica, sans-serif',
				'variants' => array(
					'regular',
					'italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'IM Fell Double Pica SC, sans-serif' => array(
				'label'  => 'IM Fell Double Pica SC, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'IM Fell English, sans-serif' => array(
				'label'  => 'IM Fell English, sans-serif',
				'variants' => array(
					'regular',
					'italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'IM Fell English SC, sans-serif' => array(
				'label'  => 'IM Fell English SC, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'IM Fell French Canon, sans-serif' => array(
				'label'  => 'IM Fell French Canon, sans-serif',
				'variants' => array(
					'regular',
					'italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'IM Fell French Canon SC, sans-serif' => array(
				'label'  => 'IM Fell French Canon SC, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'IM Fell Great Primer, sans-serif' => array(
				'label'  => 'IM Fell Great Primer, sans-serif',
				'variants' => array(
					'regular',
					'italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'IM Fell Great Primer SC, sans-serif' => array(
				'label'  => 'IM Fell Great Primer SC, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Iceberg, cursive' => array(
				'label'  => 'Iceberg, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Iceland, cursive' => array(
				'label'  => 'Iceland, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Imprima, sans-serif' => array(
				'label'  => 'Imprima, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Inconsolata, monospace' => array(
				'label'  => 'Inconsolata, monospace',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Inder, sans-serif' => array(
				'label'  => 'Inder, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Indie Flower, cursive' => array(
				'label'  => 'Indie Flower, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Inika, sans-serif' => array(
				'label'  => 'Inika, sans-serif',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Irish Grover, cursive' => array(
				'label'  => 'Irish Grover, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Istok Web, sans-serif' => array(
				'label'  => 'Istok Web, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Italiana, sans-serif' => array(
				'label'  => 'Italiana, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Italianno, cursive' => array(
				'label'  => 'Italianno, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Jacques Francois, sans-serif' => array(
				'label'  => 'Jacques Francois, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Jacques Francois Shadow, cursive' => array(
				'label'  => 'Jacques Francois Shadow, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Jim Nightshade, cursive' => array(
				'label'  => 'Jim Nightshade, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Jockey One, sans-serif' => array(
				'label'  => 'Jockey One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Jolly Lodger, cursive' => array(
				'label'  => 'Jolly Lodger, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Josefin Sans, sans-serif' => array(
				'label'  => 'Josefin Sans, sans-serif',
				'variants' => array(
					'100',
					'100italic',
					'300',
					'300italic',
					'regular',
					'italic',
					'600',
					'600italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Josefin Slab, sans-serif' => array(
				'label'  => 'Josefin Slab, sans-serif',
				'variants' => array(
					'100',
					'100italic',
					'300',
					'300italic',
					'regular',
					'italic',
					'600',
					'600italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Joti One, cursive' => array(
				'label'  => 'Joti One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Judson, sans-serif' => array(
				'label'  => 'Judson, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Julee, cursive' => array(
				'label'  => 'Julee, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Julius Sans One, sans-serif' => array(
				'label'  => 'Julius Sans One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Junge, sans-serif' => array(
				'label'  => 'Junge, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Jura, sans-serif' => array(
				'label'  => 'Jura, sans-serif',
				'variants' => array(
					'300',
					'regular',
					'500',
					'600',
				),
				'subsets' => array(
					'latin',
					'greek-ext',
					'cyrillic',
					'greek',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Just Another Hand, cursive' => array(
				'label'  => 'Just Another Hand, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Just Me Again Down Here, cursive' => array(
				'label'  => 'Just Me Again Down Here, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Kameron, sans-serif' => array(
				'label'  => 'Kameron, sans-serif',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Kantumruy, sans-serif' => array(
				'label'  => 'Kantumruy, sans-serif',
				'variants' => array(
					'300',
					'regular',
					'700',
				),
				'subsets' => array(
					'khmer',
				),
			),
			'Karla, sans-serif' => array(
				'label'  => 'Karla, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Kaushan Script, cursive' => array(
				'label'  => 'Kaushan Script, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Kavoon, cursive' => array(
				'label'  => 'Kavoon, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Kdam Thmor, cursive' => array(
				'label'  => 'Kdam Thmor, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'khmer',
				),
			),
			'Keania One, cursive' => array(
				'label'  => 'Keania One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Kelly Slab, cursive' => array(
				'label'  => 'Kelly Slab, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
				),
			),
			'Kenia, cursive' => array(
				'label'  => 'Kenia, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Khmer, cursive' => array(
				'label'  => 'Khmer, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'khmer',
				),
			),
			'Kite One, sans-serif' => array(
				'label'  => 'Kite One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Knewave, cursive' => array(
				'label'  => 'Knewave, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Kotta One, sans-serif' => array(
				'label'  => 'Kotta One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Koulen, cursive' => array(
				'label'  => 'Koulen, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'khmer',
				),
			),
			'Kranky, cursive' => array(
				'label'  => 'Kranky, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Kreon, sans-serif' => array(
				'label'  => 'Kreon, sans-serif',
				'variants' => array(
					'300',
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Kristi, cursive' => array(
				'label'  => 'Kristi, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Krona One, sans-serif' => array(
				'label'  => 'Krona One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'La Belle Aurore, cursive' => array(
				'label'  => 'La Belle Aurore, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Lancelot, cursive' => array(
				'label'  => 'Lancelot, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Lato, sans-serif' => array(
				'label'  => 'Lato, sans-serif',
				'variants' => array(
					'100',
					'100italic',
					'300',
					'300italic',
					'regular',
					'italic',
					'700',
					'700italic',
					'900',
					'900italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'League Script, cursive' => array(
				'label'  => 'League Script, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Leckerli One, cursive' => array(
				'label'  => 'Leckerli One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Ledger, sans-serif' => array(
				'label'  => 'Ledger, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
				),
			),
			'Lekton, sans-serif' => array(
				'label'  => 'Lekton, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Lemon, cursive' => array(
				'label'  => 'Lemon, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Libre Baskerville, sans-serif' => array(
				'label'  => 'Libre Baskerville, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Life Savers, cursive' => array(
				'label'  => 'Life Savers, cursive',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Lilita One, cursive' => array(
				'label'  => 'Lilita One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Lily Script One, cursive' => array(
				'label'  => 'Lily Script One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Limelight, cursive' => array(
				'label'  => 'Limelight, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Linden Hill, sans-serif' => array(
				'label'  => 'Linden Hill, sans-serif',
				'variants' => array(
					'regular',
					'italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Lobster, cursive' => array(
				'label'  => 'Lobster, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Lobster Two, cursive' => array(
				'label'  => 'Lobster Two, cursive',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Londrina Outline, cursive' => array(
				'label'  => 'Londrina Outline, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Londrina Shadow, cursive' => array(
				'label'  => 'Londrina Shadow, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Londrina Sketch, cursive' => array(
				'label'  => 'Londrina Sketch, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Londrina Solid, cursive' => array(
				'label'  => 'Londrina Solid, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Lora, sans-serif' => array(
				'label'  => 'Lora, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
				),
			),
			'Love Ya Like A Sister, cursive' => array(
				'label'  => 'Love Ya Like A Sister, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Loved by the King, cursive' => array(
				'label'  => 'Loved by the King, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Lovers Quarrel, cursive' => array(
				'label'  => 'Lovers Quarrel, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Luckiest Guy, cursive' => array(
				'label'  => 'Luckiest Guy, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Lusitana, sans-serif' => array(
				'label'  => 'Lusitana, sans-serif',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Lustria, sans-serif' => array(
				'label'  => 'Lustria, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Macondo, cursive' => array(
				'label'  => 'Macondo, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Macondo Swash Caps, cursive' => array(
				'label'  => 'Macondo Swash Caps, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Magra, sans-serif' => array(
				'label'  => 'Magra, sans-serif',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Maiden Orange, cursive' => array(
				'label'  => 'Maiden Orange, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Mako, sans-serif' => array(
				'label'  => 'Mako, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Marcellus, sans-serif' => array(
				'label'  => 'Marcellus, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Marcellus SC, sans-serif' => array(
				'label'  => 'Marcellus SC, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Marck Script, cursive' => array(
				'label'  => 'Marck Script, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
				),
			),
			'Margarine, cursive' => array(
				'label'  => 'Margarine, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Marko One, sans-serif' => array(
				'label'  => 'Marko One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Marmelad, sans-serif' => array(
				'label'  => 'Marmelad, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
				),
			),
			'Marvel, sans-serif' => array(
				'label'  => 'Marvel, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Mate, sans-serif' => array(
				'label'  => 'Mate, sans-serif',
				'variants' => array(
					'regular',
					'italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Mate SC, sans-serif' => array(
				'label'  => 'Mate SC, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Maven Pro, sans-serif' => array(
				'label'  => 'Maven Pro, sans-serif',
				'variants' => array(
					'regular',
					'500',
					'700',
					'900',
				),
				'subsets' => array(
					'latin',
				),
			),
			'McLaren, cursive' => array(
				'label'  => 'McLaren, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Meddon, cursive' => array(
				'label'  => 'Meddon, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'MedievalSharp, cursive' => array(
				'label'  => 'MedievalSharp, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Medula One, cursive' => array(
				'label'  => 'Medula One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Megrim, cursive' => array(
				'label'  => 'Megrim, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Meie Script, cursive' => array(
				'label'  => 'Meie Script, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Merienda, cursive' => array(
				'label'  => 'Merienda, cursive',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Merienda One, cursive' => array(
				'label'  => 'Merienda One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Merriweather, sans-serif' => array(
				'label'  => 'Merriweather, sans-serif',
				'variants' => array(
					'300',
					'300italic',
					'regular',
					'italic',
					'700',
					'700italic',
					'900',
					'900italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Merriweather Sans, sans-serif' => array(
				'label'  => 'Merriweather Sans, sans-serif',
				'variants' => array(
					'300',
					'300italic',
					'regular',
					'italic',
					'700',
					'700italic',
					'800',
					'800italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Metal, cursive' => array(
				'label'  => 'Metal, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'khmer',
				),
			),
			'Metal Mania, cursive' => array(
				'label'  => 'Metal Mania, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Metamorphous, cursive' => array(
				'label'  => 'Metamorphous, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Metrophobic, sans-serif' => array(
				'label'  => 'Metrophobic, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Michroma, sans-serif' => array(
				'label'  => 'Michroma, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Milonga, cursive' => array(
				'label'  => 'Milonga, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Miltonian, cursive' => array(
				'label'  => 'Miltonian, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Miltonian Tattoo, cursive' => array(
				'label'  => 'Miltonian Tattoo, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Miniver, cursive' => array(
				'label'  => 'Miniver, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Miss Fajardose, cursive' => array(
				'label'  => 'Miss Fajardose, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Modern Antiqua, cursive' => array(
				'label'  => 'Modern Antiqua, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Molengo, sans-serif' => array(
				'label'  => 'Molengo, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Molle, cursive' => array(
				'label'  => 'Molle, cursive',
				'variants' => array(
					'italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Monda, sans-serif' => array(
				'label'  => 'Monda, sans-serif',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Monofett, cursive' => array(
				'label'  => 'Monofett, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Monoton, cursive' => array(
				'label'  => 'Monoton, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Monsieur La Doulaise, cursive' => array(
				'label'  => 'Monsieur La Doulaise, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Montaga, sans-serif' => array(
				'label'  => 'Montaga, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Montez, cursive' => array(
				'label'  => 'Montez, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Montserrat, sans-serif' => array(
				'label'  => 'Montserrat, sans-serif',
				'variants' => array(
					'regular',
					'600',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Montserrat Alternates, sans-serif' => array(
				'label'  => 'Montserrat Alternates, sans-serif',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Montserrat Subrayada, sans-serif' => array(
				'label'  => 'Montserrat Subrayada, sans-serif',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Moul, cursive' => array(
				'label'  => 'Moul, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'khmer',
				),
			),
			'Moulpali, cursive' => array(
				'label'  => 'Moulpali, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'khmer',
				),
			),
			'Mountains of Christmas, cursive' => array(
				'label'  => 'Mountains of Christmas, cursive',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Mouse Memoirs, sans-serif' => array(
				'label'  => 'Mouse Memoirs, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Mr Bedfort, cursive' => array(
				'label'  => 'Mr Bedfort, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Mr Dafoe, cursive' => array(
				'label'  => 'Mr Dafoe, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Mr De Haviland, cursive' => array(
				'label'  => 'Mr De Haviland, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Mrs Saint Delafield, cursive' => array(
				'label'  => 'Mrs Saint Delafield, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Mrs Sheppards, cursive' => array(
				'label'  => 'Mrs Sheppards, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Muli, sans-serif' => array(
				'label'  => 'Muli, sans-serif',
				'variants' => array(
					'300',
					'300italic',
					'regular',
					'italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Mystery Quest, cursive' => array(
				'label'  => 'Mystery Quest, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Neucha, cursive' => array(
				'label'  => 'Neucha, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
				),
			),
			'Neuton, sans-serif' => array(
				'label'  => 'Neuton, sans-serif',
				'variants' => array(
					'200',
					'300',
					'regular',
					'italic',
					'700',
					'800',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'New Rocker, cursive' => array(
				'label'  => 'New Rocker, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'News Cycle, sans-serif' => array(
				'label'  => 'News Cycle, sans-serif',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Niconne, cursive' => array(
				'label'  => 'Niconne, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Nixie One, cursive' => array(
				'label'  => 'Nixie One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Nobile, sans-serif' => array(
				'label'  => 'Nobile, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Nokora, serif' => array(
				'label'  => 'Nokora, serif',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'khmer',
				),
			),
			'Norican, cursive' => array(
				'label'  => 'Norican, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Nosifer, cursive' => array(
				'label'  => 'Nosifer, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Nothing You Could Do, cursive' => array(
				'label'  => 'Nothing You Could Do, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Noticia Text, sans-serif' => array(
				'label'  => 'Noticia Text, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'vietnamese',
					'latin-ext',
				),
			),
			'Noto Sans, sans-serif' => array(
				'label'  => 'Noto Sans, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'greek-ext',
					'cyrillic',
					'greek',
					'vietnamese',
					'latin-ext',
					'devanagari',
					'cyrillic-ext',
				),
			),
			'Noto Serif, sans-serif' => array(
				'label'  => 'Noto Serif, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'greek-ext',
					'cyrillic',
					'greek',
					'vietnamese',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Nova Cut, cursive' => array(
				'label'  => 'Nova Cut, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Nova Flat, cursive' => array(
				'label'  => 'Nova Flat, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Nova Mono, monospace' => array(
				'label'  => 'Nova Mono, monospace',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'greek',
				),
			),
			'Nova Oval, cursive' => array(
				'label'  => 'Nova Oval, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Nova Round, cursive' => array(
				'label'  => 'Nova Round, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Nova Script, cursive' => array(
				'label'  => 'Nova Script, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Nova Slim, cursive' => array(
				'label'  => 'Nova Slim, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Nova Square, cursive' => array(
				'label'  => 'Nova Square, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Numans, sans-serif' => array(
				'label'  => 'Numans, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Nunito, sans-serif' => array(
				'label'  => 'Nunito, sans-serif',
				'variants' => array(
					'300',
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Odor Mean Chey, cursive' => array(
				'label'  => 'Odor Mean Chey, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'khmer',
				),
			),
			'Offside, cursive' => array(
				'label'  => 'Offside, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Old Standard TT, sans-serif' => array(
				'label'  => 'Old Standard TT, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Oldenburg, cursive' => array(
				'label'  => 'Oldenburg, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Oleo Script, cursive' => array(
				'label'  => 'Oleo Script, cursive',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Oleo Script Swash Caps, cursive' => array(
				'label'  => 'Oleo Script Swash Caps, cursive',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Open Sans, sans-serif' => array(
				'label'  => 'Open Sans, sans-serif',
				'variants' => array(
					'300',
					'300italic',
					'regular',
					'italic',
					'600',
					'600italic',
					'700',
					'700italic',
					'800',
					'800italic',
				),
				'subsets' => array(
					'latin',
					'greek-ext',
					'cyrillic',
					'greek',
					'vietnamese',
					'latin-ext',
					'devanagari',
					'cyrillic-ext',
				),
			),
			'Open Sans Condensed, sans-serif' => array(
				'label'  => 'Open Sans Condensed, sans-serif',
				'variants' => array(
					'300',
					'300italic',
					'700',
				),
				'subsets' => array(
					'latin',
					'greek-ext',
					'cyrillic',
					'greek',
					'vietnamese',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Oranienbaum, sans-serif' => array(
				'label'  => 'Oranienbaum, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Orbitron, sans-serif' => array(
				'label'  => 'Orbitron, sans-serif',
				'variants' => array(
					'regular',
					'500',
					'700',
					'900',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Oregano, cursive' => array(
				'label'  => 'Oregano, cursive',
				'variants' => array(
					'regular',
					'italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Orienta, sans-serif' => array(
				'label'  => 'Orienta, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Original Surfer, cursive' => array(
				'label'  => 'Original Surfer, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Oswald, sans-serif' => array(
				'label'  => 'Oswald, sans-serif',
				'variants' => array(
					'300',
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Over the Rainbow, cursive' => array(
				'label'  => 'Over the Rainbow, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Overlock, cursive' => array(
				'label'  => 'Overlock, cursive',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
					'900',
					'900italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Overlock SC, cursive' => array(
				'label'  => 'Overlock SC, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Ovo, sans-serif' => array(
				'label'  => 'Ovo, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Oxygen, sans-serif' => array(
				'label'  => 'Oxygen, sans-serif',
				'variants' => array(
					'300',
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Oxygen Mono, monospace' => array(
				'label'  => 'Oxygen Mono, monospace',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'PT Mono, monospace' => array(
				'label'  => 'PT Mono, monospace',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'PT Sans, sans-serif' => array(
				'label'  => 'PT Sans, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'PT Sans Caption, sans-serif' => array(
				'label'  => 'PT Sans Caption, sans-serif',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'PT Sans Narrow, sans-serif' => array(
				'label'  => 'PT Sans Narrow, sans-serif',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'PT Serif, sans-serif' => array(
				'label'  => 'PT Serif, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'PT Serif Caption, sans-serif' => array(
				'label'  => 'PT Serif Caption, sans-serif',
				'variants' => array(
					'regular',
					'italic',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Pacifico, cursive' => array(
				'label'  => 'Pacifico, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Paprika, cursive' => array(
				'label'  => 'Paprika, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Parisienne, cursive' => array(
				'label'  => 'Parisienne, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Passero One, cursive' => array(
				'label'  => 'Passero One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Passion One, cursive' => array(
				'label'  => 'Passion One, cursive',
				'variants' => array(
					'regular',
					'700',
					'900',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Pathway Gothic One, sans-serif' => array(
				'label'  => 'Pathway Gothic One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Patrick Hand, cursive' => array(
				'label'  => 'Patrick Hand, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'vietnamese',
					'latin-ext',
				),
			),
			'Patrick Hand SC, cursive' => array(
				'label'  => 'Patrick Hand SC, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'vietnamese',
					'latin-ext',
				),
			),
			'Patua One, cursive' => array(
				'label'  => 'Patua One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Paytone One, sans-serif' => array(
				'label'  => 'Paytone One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Peralta, cursive' => array(
				'label'  => 'Peralta, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Permanent Marker, cursive' => array(
				'label'  => 'Permanent Marker, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Petit Formal Script, cursive' => array(
				'label'  => 'Petit Formal Script, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Petrona, sans-serif' => array(
				'label'  => 'Petrona, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Philosopher, sans-serif' => array(
				'label'  => 'Philosopher, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
				),
			),
			'Piedra, cursive' => array(
				'label'  => 'Piedra, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Pinyon Script, cursive' => array(
				'label'  => 'Pinyon Script, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Pirata One, cursive' => array(
				'label'  => 'Pirata One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Plaster, cursive' => array(
				'label'  => 'Plaster, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Play, sans-serif' => array(
				'label'  => 'Play, sans-serif',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'greek-ext',
					'cyrillic',
					'greek',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Playball, cursive' => array(
				'label'  => 'Playball, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Playfair Display, sans-serif' => array(
				'label'  => 'Playfair Display, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
					'900',
					'900italic',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
				),
			),
			'Playfair Display SC, sans-serif' => array(
				'label'  => 'Playfair Display SC, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
					'900',
					'900italic',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
				),
			),
			'Podkova, sans-serif' => array(
				'label'  => 'Podkova, sans-serif',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Poiret One, cursive' => array(
				'label'  => 'Poiret One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
				),
			),
			'Poller One, cursive' => array(
				'label'  => 'Poller One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Poly, sans-serif' => array(
				'label'  => 'Poly, sans-serif',
				'variants' => array(
					'regular',
					'italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Pompiere, cursive' => array(
				'label'  => 'Pompiere, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Pontano Sans, sans-serif' => array(
				'label'  => 'Pontano Sans, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Port Lligat Sans, sans-serif' => array(
				'label'  => 'Port Lligat Sans, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Port Lligat Slab, sans-serif' => array(
				'label'  => 'Port Lligat Slab, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Prata, sans-serif' => array(
				'label'  => 'Prata, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Preahvihear, cursive' => array(
				'label'  => 'Preahvihear, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'khmer',
				),
			),
			'Press Start 2P, cursive' => array(
				'label'  => 'Press Start 2P, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'greek',
					'latin-ext',
				),
			),
			'Princess Sofia, cursive' => array(
				'label'  => 'Princess Sofia, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Prociono, sans-serif' => array(
				'label'  => 'Prociono, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Prosto One, cursive' => array(
				'label'  => 'Prosto One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
				),
			),
			'Puritan, sans-serif' => array(
				'label'  => 'Puritan, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Purple Purse, cursive' => array(
				'label'  => 'Purple Purse, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Quando, sans-serif' => array(
				'label'  => 'Quando, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Quantico, sans-serif' => array(
				'label'  => 'Quantico, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Quattrocento, sans-serif' => array(
				'label'  => 'Quattrocento, sans-serif',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Quattrocento Sans, sans-serif' => array(
				'label'  => 'Quattrocento Sans, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Questrial, sans-serif' => array(
				'label'  => 'Questrial, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Quicksand, sans-serif' => array(
				'label'  => 'Quicksand, sans-serif',
				'variants' => array(
					'300',
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Quintessential, cursive' => array(
				'label'  => 'Quintessential, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Qwigley, cursive' => array(
				'label'  => 'Qwigley, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Racing Sans One, cursive' => array(
				'label'  => 'Racing Sans One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Radley, sans-serif' => array(
				'label'  => 'Radley, sans-serif',
				'variants' => array(
					'regular',
					'italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Raleway, sans-serif' => array(
				'label'  => 'Raleway, sans-serif',
				'variants' => array(
					'100',
					'200',
					'300',
					'regular',
					'500',
					'600',
					'700',
					'800',
					'900',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Raleway Dots, cursive' => array(
				'label'  => 'Raleway Dots, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Rambla, sans-serif' => array(
				'label'  => 'Rambla, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Rammetto One, cursive' => array(
				'label'  => 'Rammetto One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Ranchers, cursive' => array(
				'label'  => 'Ranchers, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Rancho, cursive' => array(
				'label'  => 'Rancho, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Rationale, sans-serif' => array(
				'label'  => 'Rationale, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Redressed, cursive' => array(
				'label'  => 'Redressed, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Reenie Beanie, cursive' => array(
				'label'  => 'Reenie Beanie, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Revalia, cursive' => array(
				'label'  => 'Revalia, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Ribeye, cursive' => array(
				'label'  => 'Ribeye, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Ribeye Marrow, cursive' => array(
				'label'  => 'Ribeye Marrow, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Righteous, cursive' => array(
				'label'  => 'Righteous, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Risque, cursive' => array(
				'label'  => 'Risque, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Roboto, sans-serif' => array(
				'label'  => 'Roboto, sans-serif',
				'variants' => array(
					'100',
					'100italic',
					'300',
					'300italic',
					'regular',
					'italic',
					'500',
					'500italic',
					'700',
					'700italic',
					'900',
					'900italic',
				),
				'subsets' => array(
					'latin',
					'greek-ext',
					'cyrillic',
					'greek',
					'vietnamese',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Roboto Condensed, sans-serif' => array(
				'label'  => 'Roboto Condensed, sans-serif',
				'variants' => array(
					'300',
					'300italic',
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'greek-ext',
					'cyrillic',
					'greek',
					'vietnamese',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Roboto Slab, sans-serif' => array(
				'label'  => 'Roboto Slab, sans-serif',
				'variants' => array(
					'100',
					'300',
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'greek-ext',
					'cyrillic',
					'greek',
					'vietnamese',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Rochester, cursive' => array(
				'label'  => 'Rochester, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Rock Salt, cursive' => array(
				'label'  => 'Rock Salt, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Rokkitt, sans-serif' => array(
				'label'  => 'Rokkitt, sans-serif',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Romanesco, cursive' => array(
				'label'  => 'Romanesco, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Ropa Sans, sans-serif' => array(
				'label'  => 'Ropa Sans, sans-serif',
				'variants' => array(
					'regular',
					'italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Rosario, sans-serif' => array(
				'label'  => 'Rosario, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Rosarivo, sans-serif' => array(
				'label'  => 'Rosarivo, sans-serif',
				'variants' => array(
					'regular',
					'italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Rouge Script, cursive' => array(
				'label'  => 'Rouge Script, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Ruda, sans-serif' => array(
				'label'  => 'Ruda, sans-serif',
				'variants' => array(
					'regular',
					'700',
					'900',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Rubik One, sans-serif' => array(
				'label'  => 'Rubik One, sans-serif',
				'variants' => array(
					'400',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Rubik Mono One, sans-serif' => array(
				'label'  => 'Rubik Mono One, sans-serif',
				'variants' => array(
					'400',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Rufina, sans-serif' => array(
				'label'  => 'Rufina, sans-serif',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Ruge Boogie, cursive' => array(
				'label'  => 'Ruge Boogie, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Ruluko, sans-serif' => array(
				'label'  => 'Ruluko, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Rum Raisin, sans-serif' => array(
				'label'  => 'Rum Raisin, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Ruslan Display, cursive' => array(
				'label'  => 'Ruslan Display, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Russo One, sans-serif' => array(
				'label'  => 'Russo One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
				),
			),
			'Ruthie, cursive' => array(
				'label'  => 'Ruthie, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Rye, cursive' => array(
				'label'  => 'Rye, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Sacramento, cursive' => array(
				'label'  => 'Sacramento, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Sail, cursive' => array(
				'label'  => 'Sail, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Salsa, cursive' => array(
				'label'  => 'Salsa, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Sanchez, sans-serif' => array(
				'label'  => 'Sanchez, sans-serif',
				'variants' => array(
					'regular',
					'italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Sancreek, cursive' => array(
				'label'  => 'Sancreek, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Sansita One, sans-serif' => array(
				'label'  => 'Sansita One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Sarina, cursive' => array(
				'label'  => 'Sarina, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Satisfy, cursive' => array(
				'label'  => 'Satisfy, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Scada, sans-serif' => array(
				'label'  => 'Scada, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
				),
			),
			'Schoolbell, cursive' => array(
				'label'  => 'Schoolbell, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Seaweed Script, cursive' => array(
				'label'  => 'Seaweed Script, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Sevillana, cursive' => array(
				'label'  => 'Sevillana, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Seymour One, sans-serif' => array(
				'label'  => 'Seymour One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
				),
			),
			'Shadows Into Light, cursive' => array(
				'label'  => 'Shadows Into Light, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Shadows Into Light Two, cursive' => array(
				'label'  => 'Shadows Into Light Two, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Shanti, sans-serif' => array(
				'label'  => 'Shanti, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Share, cursive' => array(
				'label'  => 'Share, cursive',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Share Tech, sans-serif' => array(
				'label'  => 'Share Tech, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Share Tech Mono, monospace' => array(
				'label'  => 'Share Tech Mono, monospace',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Shojumaru, cursive' => array(
				'label'  => 'Shojumaru, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Short Stack, cursive' => array(
				'label'  => 'Short Stack, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Siemreap, cursive' => array(
				'label'  => 'Siemreap, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'khmer',
				),
			),
			'Sigmar One, cursive' => array(
				'label'  => 'Sigmar One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Signika, sans-serif' => array(
				'label'  => 'Signika, sans-serif',
				'variants' => array(
					'300',
					'regular',
					'600',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Signika Negative, sans-serif' => array(
				'label'  => 'Signika Negative, sans-serif',
				'variants' => array(
					'300',
					'regular',
					'600',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Simonetta, cursive' => array(
				'label'  => 'Simonetta, cursive',
				'variants' => array(
					'regular',
					'italic',
					'900',
					'900italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Sintony, sans-serif' => array(
				'label'  => 'Sintony, sans-serif',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Sirin Stencil, cursive' => array(
				'label'  => 'Sirin Stencil, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Six Caps, sans-serif' => array(
				'label'  => 'Six Caps, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Skranji, cursive' => array(
				'label'  => 'Skranji, cursive',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Slackey, cursive' => array(
				'label'  => 'Slackey, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Smokum, cursive' => array(
				'label'  => 'Smokum, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Smythe, cursive' => array(
				'label'  => 'Smythe, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Sniglet, cursive' => array(
				'label'  => 'Sniglet, cursive',
				'variants' => array(
					'regular',
					'800',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Snippet, sans-serif' => array(
				'label'  => 'Snippet, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Snowburst One, cursive' => array(
				'label'  => 'Snowburst One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Sofadi One, cursive' => array(
				'label'  => 'Sofadi One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Sofia, cursive' => array(
				'label'  => 'Sofia, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Sonsie One, cursive' => array(
				'label'  => 'Sonsie One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Sorts Mill Goudy, sans-serif' => array(
				'label'  => 'Sorts Mill Goudy, sans-serif',
				'variants' => array(
					'regular',
					'italic',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Source Code Pro, monospace' => array(
				'label'  => 'Source Code Pro, monospace',
				'variants' => array(
					'200',
					'300',
					'regular',
					'500',
					'600',
					'700',
					'900',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Source Sans Pro, sans-serif' => array(
				'label'  => 'Source Sans Pro, sans-serif',
				'variants' => array(
					'200',
					'200italic',
					'300',
					'300italic',
					'regular',
					'italic',
					'600',
					'600italic',
					'700',
					'700italic',
					'900',
					'900italic',
				),
				'subsets' => array(
					'latin',
					'vietnamese',
					'latin-ext',
				),
			),
			'Source Serif Pro, sans-serif' => array(
				'label'  => 'Source Serif Pro, sans-serif',
				'variants' => array(
					'400',
					'600',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Special Elite, cursive' => array(
				'label'  => 'Special Elite, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Spicy Rice, cursive' => array(
				'label'  => 'Spicy Rice, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Spinnaker, sans-serif' => array(
				'label'  => 'Spinnaker, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Spirax, cursive' => array(
				'label'  => 'Spirax, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Squada One, cursive' => array(
				'label'  => 'Squada One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Stalemate, cursive' => array(
				'label'  => 'Stalemate, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Stalinist One, cursive' => array(
				'label'  => 'Stalinist One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
				),
			),
			'Stardos Stencil, cursive' => array(
				'label'  => 'Stardos Stencil, cursive',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Stint Ultra Condensed, cursive' => array(
				'label'  => 'Stint Ultra Condensed, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Stint Ultra Expanded, cursive' => array(
				'label'  => 'Stint Ultra Expanded, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Stoke, sans-serif' => array(
				'label'  => 'Stoke, sans-serif',
				'variants' => array(
					'300',
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Strait, sans-serif' => array(
				'label'  => 'Strait, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Sue Ellen Francisco, cursive' => array(
				'label'  => 'Sue Ellen Francisco, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Sunshiney, cursive' => array(
				'label'  => 'Sunshiney, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Supermercado One, cursive' => array(
				'label'  => 'Supermercado One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Suwannaphum, cursive' => array(
				'label'  => 'Suwannaphum, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'khmer',
				),
			),
			'Swanky and Moo Moo, cursive' => array(
				'label'  => 'Swanky and Moo Moo, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Syncopate, sans-serif' => array(
				'label'  => 'Syncopate, sans-serif',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Tangerine, cursive' => array(
				'label'  => 'Tangerine, cursive',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Taprom, cursive' => array(
				'label'  => 'Taprom, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'khmer',
				),
			),
			'Tauri, sans-serif' => array(
				'label'  => 'Tauri, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Telex, sans-serif' => array(
				'label'  => 'Telex, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Tenor Sans, sans-serif' => array(
				'label'  => 'Tenor Sans, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Text Me One, sans-serif' => array(
				'label'  => 'Text Me One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'The Girl Next Door, cursive' => array(
				'label'  => 'The Girl Next Door, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Tienne, sans-serif' => array(
				'label'  => 'Tienne, sans-serif',
				'variants' => array(
					'regular',
					'700',
					'900',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Tinos, sans-serif' => array(
				'label'  => 'Tinos, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'greek-ext',
					'cyrillic',
					'greek',
					'vietnamese',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Titan One, cursive' => array(
				'label'  => 'Titan One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Titillium Web, sans-serif' => array(
				'label'  => 'Titillium Web, sans-serif',
				'variants' => array(
					'200',
					'200italic',
					'300',
					'300italic',
					'regular',
					'italic',
					'600',
					'600italic',
					'700',
					'700italic',
					'900',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Trade Winds, cursive' => array(
				'label'  => 'Trade Winds, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Trocchi, serif' => array(
				'label'  => 'Trocchi, serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Trochut, cursive' => array(
				'label'  => 'Trochut, cursive',
				'variants' => array(
					'regular',
					'italic',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Trykker, sans-serif' => array(
				'label'  => 'Trykker, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Tulpen One, cursive' => array(
				'label'  => 'Tulpen One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Ubuntu, sans-serif' => array(
				'label'  => 'Ubuntu, sans-serif',
				'variants' => array(
					'300',
					'300italic',
					'regular',
					'italic',
					'500',
					'500italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'greek-ext',
					'cyrillic',
					'greek',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Ubuntu Condensed, sans-serif' => array(
				'label'  => 'Ubuntu Condensed, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'greek-ext',
					'cyrillic',
					'greek',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Ubuntu Mono, monospace' => array(
				'label'  => 'Ubuntu Mono, monospace',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
					'greek-ext',
					'cyrillic',
					'greek',
					'latin-ext',
					'cyrillic-ext',
				),
			),
			'Ultra, sans-serif' => array(
				'label'  => 'Ultra, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Uncial Antiqua, cursive' => array(
				'label'  => 'Uncial Antiqua, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Underdog, cursive' => array(
				'label'  => 'Underdog, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
				),
			),
			'Unica One, cursive' => array(
				'label'  => 'Unica One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'UnifrakturCook, cursive' => array(
				'label'  => 'UnifrakturCook, cursive',
				'variants' => array(
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'UnifrakturMaguntia, cursive' => array(
				'label'  => 'UnifrakturMaguntia, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Unkempt, cursive' => array(
				'label'  => 'Unkempt, cursive',
				'variants' => array(
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Unlock, cursive' => array(
				'label'  => 'Unlock, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Unna, sans-serif' => array(
				'label'  => 'Unna, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'VT323, monospace' => array(
				'label'  => 'VT323, monospace',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Vampiro One, cursive' => array(
				'label'  => 'Vampiro One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Varela, sans-serif' => array(
				'label'  => 'Varela, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Varela Round, sans-serif' => array(
				'label'  => 'Varela Round, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Vast Shadow, cursive' => array(
				'label'  => 'Vast Shadow, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Vibur, cursive' => array(
				'label'  => 'Vibur, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Vidaloka, sans-serif' => array(
				'label'  => 'Vidaloka, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Viga, sans-serif' => array(
				'label'  => 'Viga, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Voces, cursive' => array(
				'label'  => 'Voces, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Volkhov, sans-serif' => array(
				'label'  => 'Volkhov, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Vollkorn, sans-serif' => array(
				'label'  => 'Vollkorn, sans-serif',
				'variants' => array(
					'regular',
					'italic',
					'700',
					'700italic',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Voltaire, sans-serif' => array(
				'label'  => 'Voltaire, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Waiting for the Sunrise, cursive' => array(
				'label'  => 'Waiting for the Sunrise, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Wallpoet, cursive' => array(
				'label'  => 'Wallpoet, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Walter Turncoat, cursive' => array(
				'label'  => 'Walter Turncoat, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Warnes, cursive' => array(
				'label'  => 'Warnes, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Wellfleet, cursive' => array(
				'label'  => 'Wellfleet, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Wendy One, sans-serif' => array(
				'label'  => 'Wendy One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Wire One, sans-serif' => array(
				'label'  => 'Wire One, sans-serif',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Yanone Kaffeesatz, sans-serif' => array(
				'label'  => 'Yanone Kaffeesatz, sans-serif',
				'variants' => array(
					'200',
					'300',
					'regular',
					'700',
				),
				'subsets' => array(
					'latin',
					'latin-ext',
				),
			),
			'Yellowtail, cursive' => array(
				'label'  => 'Yellowtail, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Yeseva One, cursive' => array(
				'label'  => 'Yeseva One, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
					'cyrillic',
					'latin-ext',
				),
			),
			'Yesteryear, cursive' => array(
				'label'  => 'Yesteryear, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
			'Zeyada, cursive' => array(
				'label'  => 'Zeyada, cursive',
				'variants' => array(
					'regular',
				),
				'subsets' => array(
					'latin',
				),
			),
		) );
	}

	/**
	 * Check if provided font is from Google Fonts collection
	 *
	 * @param string $font Font name.
	 *
	 * @return bool
	 */
	public static function is_google_font( $font ) {
		$google_fonts = self::vct_theme_google_fonts();
		$families     = self::get_google_font_families();

		// If the font already has a font family in its name just make sure it exists in $google_fonts.
		if ( self::is_google_font_has_family_suffix( $font, $families ) ) {
			return array_key_exists( $font, $google_fonts );
		}

		// Font can be with or without family, e.g. "Roboto" or "Roboto, sans-serif",
		// while in $google_fonts keys are only with font-family.
		$font = trim( str_replace( ',', '', $font ) );
		foreach ( $families as $family ) {
			if ( array_key_exists( "{$font}, {$family}", $google_fonts ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Check if Google Font already downloaded.
	 *
	 * This function checks only if .css file exists, because
	 * we don't know in advance what font files (variants or extensions)
	 * will be in the font folder.
	 *
	 * @param string $font Font name.
	 *
	 * @return bool
	 */
	public static function is_google_font_exists_locally( $font ) {
		$name    = self::get_google_font_name( $font );
		$font_id = self::get_google_font_id( $font );
		$subdir  = self::get_google_font_dir( $font_id );
		$uploads = wp_get_upload_dir();

		return file_exists( "{$uploads['basedir']}/{$subdir}/{$name}.css" );
	}

	/**
	 * Checks if font name contains a font family suffix
	 *
	 * @param string $font Font name, e.g. "Roboto" or "Roboto, sans-serif".
	 * @param array  $families Font families.
	 *
	 * @return bool
	 */
	public static function is_google_font_has_family_suffix( $font, array $families = array() ) {
		if ( empty( $families ) ) {
			$families = self::get_google_font_families();
		}

		return false !== visualcomposerstarter_strpos_array( $font, $families );
	}

	/**
	 * Get the ID of the font
	 *
	 * This method simply converts the font family name into lowercase
	 * and with dashes instead of spaces. For example:
	 * - Roboto, sans-serif -> roboto
	 * - ABeeZee, sans-serif -> abeezee
	 * - Yanone Kaffeesatz -> yanone-kaffeesatz
	 * - Waiting for the Sunrise -> waiting-for-the-sunrise
	 * - 'Waiting for the Sunrise' -> waiting-for-the-sunrise
	 * and so on.
	 *
	 * @param string $font Font family name.
	 *
	 * @return string
	 */
	public static function get_google_font_id( $font ) {
		// Replace possible multiple whitespaces with single one.
		$font = preg_replace( '/\\s\\s+/', ' ', $font );
		$font = mb_strtolower( $font );
		$font = str_replace(
			array(
				'sans-serif',
				'cursive',
				'monospace',
				',',
				' ', // space.
				"'", // single quote.
			),
			array(
				'',
				'',
				'',
				'',
				'-', // to dash.
				'', // remove single quote.
			),
			$font
		);

		// Note the dash in a list of default characters.
		return trim( $font, " \n\r\t\v\x00-" );
	}

	/**
	 * Get the name of the font to save into filesystem
	 *
	 * This method converts the font family name into "PascalCase". For example:
	 * - Roboto, sans-serif -> Roboto
	 * - ABeeZee, sans-serif -> AbeeZee
	 * - Yanone Kaffeesatz -> YanoneKaffeesatz
	 * - Waiting for the Sunrise -> WaitingForTheSunrise
	 * and so on.
	 *
	 * @param string $font Font family name.
	 *
	 * @return string
	 */
	public static function get_google_font_name( $font ) {
		$families = self::get_google_font_families();

		// Note the single quote.
		$font = str_replace( array_merge( $families, array( ',', "'" ) ), '', $font );
		$font = mb_convert_case( $font, MB_CASE_TITLE, 'UTF-8' );
		$font = str_replace( ' ', '', $font );

		return trim( $font );
	}

	/**
	 * Get font filename by provided variant without extension
	 *
	 * Example:
	 * - Roboto, 400 -> Roboto-Regular
	 * - Roboto, 400, italic -> Roboto-Regular-Italic
	 * - Roboto, 100, italic -> Roboto-Thin-Italic
	 *
	 * @param array $font_variant Font variant.
	 *
	 * @return string
	 */
	public static function get_google_font_filename_by_variant( $font_variant ) {
		$weights = self::get_google_font_weights();

		$name   = array();
		$name[] = self::get_google_font_name( $font_variant['fontFamily'] );
		$name[] = $weights[ (int) $font_variant['fontWeight'] ];
		if ( 'italic' === $font_variant['fontStyle'] ) {
			$name[] = 'Italic';
		}

		return implode( '-', $name );
	}

	/**
	 * Get relative path to google font subdirectory
	 *
	 * @param string $font_id Font id.
	 *
	 * @return string
	 */
	public static function get_google_font_dir( $font_id ) {
		return self::PATH_TO_LOCAL_FONTS . DIRECTORY_SEPARATOR . $font_id;
	}

	/**
	 * Get a font URI hosted locally
	 *
	 * @param string $font Font family.
	 *
	 * @return string
	 */
	public static function get_google_font_uri( $font ) {
		$name    = self::get_google_font_name( $font );
		$font_id = self::get_google_font_id( $font );
		$subdir  = self::get_google_font_dir( $font_id );
		$uploads = wp_get_upload_dir();

		return "{$uploads['baseurl']}/$subdir/{$name}.css";
	}

	/**
	 * Returns a list of font families
	 *
	 * @return string[]
	 */
	public static function get_google_font_families() {
		return array(
			'sans-serif',
			'serif',
			'cursive',
			'monospace',
		);
	}

	/**
	 * Get formats
	 *
	 * @return string[]
	 */
	public static function get_google_font_formats() {
		return array(
			'eot'   => 'embedded-opentype',
			'woff2' => 'woff2',
			'woff'  => 'woff',
			'ttf'   => 'truetype',
			'svg'   => 'svg',
		);
	}

	/**
	 * Get font weights with human-readable names
	 *
	 * @return array
	 */
	public static function get_google_font_weights() {
		return array(
			100 => 'Thin',
			200 => 'ExtraLight',
			300 => 'Light',
			400 => 'Regular',
			500 => 'Medium',
			600 => 'SemiBold',
			700 => 'Bold',
			800 => 'ExtraBold',
			900 => 'Black',
		);
	}

	/**
	 * Returns a list of allowed subset for provided font name
	 *
	 * @param string $font Font name, e.g. "Roboto" or "Roboto, sans-serif".
	 *
	 * @return string[]
	 */
	public static function get_google_font_subsets( $font ) {
		$families     = self::get_google_font_families();
		$google_fonts = self::vct_theme_google_fonts();
		$google_font  = array();

		// Find the correct Google Font if font name provided without font family suffix.
		if ( ! self::is_google_font_has_family_suffix( $font, $families ) ) {
			$font = trim( str_replace( ',', '', $font ) );
			foreach ( $families as $family ) {
				if ( array_key_exists( "{$font}, {$family}", $google_fonts ) ) {
					$google_font = $google_fonts[ "{$font}, {$family}" ];
				}
			}
		} else {
			$google_font = $google_fonts[ $font ];
		}

		if ( empty( $google_font ) || empty( $google_font['subsets'] ) ) {
			return array();
		}

		return $google_font['subsets'];
	}

	/**
	 * Generate CSS declarations like "width: auto;", "background-color: red;", etc.
	 *
	 * @param array $props Array of properties where field is a property name
	 *                     and value is a property value.
	 *
	 * @return string
	 */
	public static function get_css_declarations( $props ) {
		$declarations = array();

		// remove empty properties.
		$props = array_filter( $props );

		foreach ( $props as $name => $value ) {
			if ( is_scalar( $value ) ) {
				$declarations[] = "{$name}: {$value};";
				continue;
			}

			/*
			 * $value may be an array, not only scalar,
			 * in case of multiple declarations, like background gradients, etc.
			 *
			 * background: white;
			 * background: -moz-linear-gradient....
			 *
			 * $sub (sub value) should be a string!
			 */
			foreach ( (array) $value as $sub ) {
				$declarations[] = "{$name}: {$sub};";
			}
		}

		return implode( ' ', $declarations );
	}

	/**
	 * Generate CSS rules in format .selector {property: value;
	 *
	 * @param string|array $selectors Classes or tags, array or divided by whitespace.
	 * @param string|array $props     Array of css rules.
	 *
	 * @return string
	 */
	public static function get_css_rules( $selectors, $props ) {
		// Convert to string.
		if ( is_array( $selectors ) ) {
			$selectors = implode( ', ', $selectors );
		}

		// Convert to string, too.
		if ( is_array( $props ) ) {
			$props = self::get_css_declarations( $props );
		}

		return sprintf( '%1$s {%2$s}', $selectors, $props );
	}

	/**
	 * Download a font from Google Fonts and store it locally
	 *
	 * @param string $font Font family.
	 *
	 * @return bool|WP_Error
	 */
	public static function download_google_font( $font ) {
		$font_id  = self::get_google_font_id( $font );
		$subsets  = self::get_google_font_subsets( $font );
		$variants = self::vct_theme_google_font_variants( $font );
		$response = self::request_google_font_api( $font_id, $subsets, $variants, array( 'woff', 'woff2' ) );
		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$code = wp_remote_retrieve_response_code( $response );
		$body = json_decode( wp_remote_retrieve_body( $response ), true );
		if ( 200 !== (int) $code || empty( $body ) ) {
			return new WP_Error(
				'vct-google-font-not-found',
				/* translators: %s is a font family name */
				sprintf( esc_html__( "'%s' font not found.", 'visual-composer-starter' ), $font )
			);
		}

		// Can't generate a font-face without variants.
		if ( empty( $body['variants'] ) ) {
			return new WP_Error(
				'vct-google-font-no-variants',
				/* translators: %s is a font name */
				sprintf( esc_html__( "Missing variants for font '%s'.", 'visual-composer-starter' ), $font )
			);
		}

		/*
		 * Get only required variants, because Google Fonts Helper API does not support variants and formats
		 * without passing an argument for downloading a zip.
		 */
		$fonts = array();
		foreach ( $body['variants'] as $font_variant ) {
			// Variant ID examples: 100, 100italic, regular, italic and so on.
			if ( empty( $variants ) || ! in_array( (string) $font_variant['id'], $variants, true ) ) {
				continue;
			}

			$fonts[] = $font_variant;
		}

		// Allow uploading .woff, .woff2 files.
		add_filter( self::$filter_type, array( 'VisualComposerStarter_Fonts', 'allow_uploading_fonts' ) );
		// Prevent creating a year/month subdirectory in uploads.
		self::$font_id = $font_id;
		add_filter( 'upload_dir', array( 'VisualComposerStarter_Fonts', 'modify_uploads_subdir' ) );

		// Download font file(s) and generate @font-face rules.
		$font_faces = array();
		foreach ( $fonts as $font_variant ) {
			$font_variant_files = self::download_google_font_files( $font_variant, array( 'woff', 'woff2' ) );
			if ( empty( $font_variant_files ) ) {
				continue;
			}

			$font_faces[] = self::generate_google_font_face( $font_variant, $font_variant_files );
		}

		// Upload a .css file with @font-face rules in the same directory as font files.
		$is_css_uploaded = self::upload_google_font_css( $font, $font_faces );
		// Note: check only for WP_Error. True and false are both valid.
		if ( is_wp_error( $is_css_uploaded ) ) {
			return $is_css_uploaded;
		}

		remove_filter( self::$filter_type, array( 'VisualComposerStarter_Fonts', 'allow_uploading_fonts' ) );
		remove_filter( 'upload_dir', array( 'VisualComposerStarter_Fonts', 'modify_uploads_subdir' ) );
		self::$font_id = ''; // reset.

		return true;
	}

	/**
	 * Download a font file(s) and "upload" it (them) via WordPress API
	 *
	 * Don't just save file into uploads directly.
	 *
	 * @param array    $font_variant Font variant.
	 * @param string[] $formats Formats, e.g. [woff, woff2]. If empty all formats will be downloaded.
	 *
	 * @return string[] Path to uploaded file(s)
	 */
	public static function download_google_font_files( $font_variant, array $formats = array() ) {
		if ( empty( $formats ) ) {
			$formats = array_keys( self::get_google_font_formats() );
		}

		$font    = $font_variant['fontFamily'];
		$font_id = self::get_google_font_id( $font );
		$subdir  = self::get_google_font_dir( $font_id );
		$files   = array();
		$uploads = wp_get_upload_dir();
		foreach ( $formats as $format ) {
			$filename = self::get_google_font_filename_by_variant( $font_variant );
			$filename = "{$filename}.{$format}";

			// Check if file exists.
			if ( file_exists( "{$uploads['basedir']}/{$subdir}/{$filename}" ) ) {
				continue;
			}

			$response = wp_remote_get( esc_url_raw( $font_variant[ $format ] ), array(
				'httpversion' => '1.1',
				'stream'      => true,
			) );

			if ( is_wp_error( $response ) ) {
				if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
					error_log( $response->get_error_message() );
				}
				continue;
			}

			if ( empty( $response['filename'] ) ) {
				if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
					error_log( sprintf( 'Failed to download a font %s.%s',
						self::get_google_font_name( $font ),
						$format
					) );
				}
				continue;
			}

			// Do not specify path when upload a file.
			$upload = wp_upload_bits( $filename, null, file_get_contents( $response['filename'] ) );
			if ( ! empty( $upload['error'] ) ) {
				if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
					error_log( sprintf( 'Failed to upload a font %s.%s by path %s',
						self::get_google_font_name( $font ),
						$format,
						"{$subdir}/{$filename}"
					) );
				}
				continue;
			}

			$files[ $format ] = "{$subdir}/{$filename}";
		} // End foreach().

		return $files;
	}

	/**
	 * Generate @font-face snippets by provided font variant
	 *
	 * @param array $font_variant Font variant.
	 * @param array $font_variant_files Uploaded font files.
	 *
	 * @return string
	 */
	public static function generate_google_font_face( $font_variant, $font_variant_files ) {
		$formats = self::get_google_font_formats();

		$src = array();
		foreach ( $font_variant_files as $format => $font_variant_file ) {
			// .css file should be in the same directory with font files.
			$src[] = sprintf( "url('%s') format('%s')", basename( $font_variant_file ), $formats[ $format ] );
		}

		return self::get_css_rules( '@font-face', array(
			'font-family' => $font_variant['fontFamily'],
			'font-style'  => $font_variant['fontStyle'],
			'font-weight' => (int) $font_variant['fontWeight'],
			'src'         => implode( ', ', $src ),
		) );
	}

	/**
	 * Upload a .css file with @font-face declarations
	 *
	 * Should be in the same place where font files located.
	 *
	 * @param string $font Font family.
	 * @param array  $font_faces A list of @font-face rules.
	 *
	 * @return bool|WP_Error True for success, false if no font faces provided, WP_Error in case of uploading errors.
	 */
	public static function upload_google_font_css( $font, $font_faces ) {
		if ( empty( $font_faces ) ) {
			return false;
		}

		$name    = self::get_google_font_name( $font );
		$font_id = self::get_google_font_id( $font );
		$subdir  = self::get_google_font_dir( $font_id );
		$uploads = wp_get_upload_dir();

		$filename = "{$name}.css";

		if ( file_exists( "{$uploads['basedir']}/{$subdir}/{$filename}" ) ) {
			return true;
		}

		$upload = wp_upload_bits( $filename, null, implode( PHP_EOL, $font_faces ) );
		if ( ! empty( $upload['error'] ) ) {
			return new WP_Error( 'vct-google-font-upload-css', $upload['error'] );
		}

		return true;
	}

	/**
	 * Request the fonts API
	 *
	 * Warning! This method utilizes an un-official API.
	 *
	 * Note! $variants and $formats args works only for downloading a zip-file.
	 *
	 * @link https://github.com/majodev/google-webfonts-helper
	 *
	 * @param string $font_id Font id.
	 * @param array  $subsets Subsets, e.g. [latin, cyrillic]. Affect only the path to the font file.
	 * @param array  $variants Variants (or styles), e.g. [100, 100italic].
	 * @param array  $formats Font formats, e.g. [woff, woff2].
	 *
	 * @return array|WP_Error
	 */
	public static function request_google_font_api( $font_id, array $subsets = array(), array $variants = array(), array $formats = array() ) {
		$url   = 'https://gwfh.mranftl.com/api/fonts/' . $font_id;
		$query = http_build_query( array(
			'subsets'  => empty( $subsets ) ? null : implode( ',', $subsets ),
			'variants' => empty( $variants ) ? null : implode( ',', $variants ),
			'formats'  => empty( $formats ) ? null : implode( ',', $formats ),
		) );

		if ( ! empty( $query ) ) {
			$query = '?' . $query;
		}

		$response = wp_remote_get( esc_url_raw( $url . $query ), array(
			'httpversion' => '1.1',
		) );

		return $response;
	}

	/**
	 * Allow uploading font files
	 *
	 * @param array $mimes Mime types.
	 *
	 * @return array
	 */
	public static function allow_uploading_fonts( $mimes ) {
		$mimes['woff']  = 'font/woff';
		$mimes['woff2'] = 'font/woff2';

		return $mimes;
	}

	/**
	 * Modify uploads subdirectory. A callback for "upload_dir" filter
	 *
	 * The goal is to prevent creating a subdirectory year/month in uploads directory
	 * when uploading font files.
	 *
	 * @uses VisualComposerStarter_Fonts::$font_id
	 *
	 * @param array $uploads Uploads directory data.
	 *
	 * @return array
	 */
	public static function modify_uploads_subdir( $uploads ) {
		$subdir = self::get_google_font_dir( self::$font_id );

		$uploads['path']   = "{$uploads['basedir']}/$subdir";
		$uploads['subdir'] = DIRECTORY_SEPARATOR . $subdir;
		$uploads['url']    = "{$uploads['baseurl']}/$subdir";

		return $uploads;
	}
}
