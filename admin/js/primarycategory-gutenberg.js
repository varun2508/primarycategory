var el = wp.element.createElement;
var customselectcontrol = wp.components.CustomSelectControl;
var useState = wp.element.useState;
var withSelect = wp.data.withSelect;
var withDispatch = wp.data.withDispatch;
var compose = wp.compose.compose;
var useEffect = wp.element.useEffect;


function PrimaryCategoryPlugin( {meta: {primary_category = false},  SetPrimaryCategory ,selectedcategorie} ) {

    const [ PrimaryCategoryState, SetPrimaryCategoryState ] = useState( primary_category );
    const [ optionsState, SetoptionsState ] = useState( [{}] );

    useEffect( () => {
        SetPrimaryCategory( PrimaryCategoryState );
    }, [PrimaryCategoryState]);


    useEffect(() => {
        let categoriesString = selectedcategorie.join();
        wp.apiFetch({
            path: `primarycategory/v1/terms/${categoriesString}`,
        }).then(data => {
            SetoptionsState(data);
        });
    }, [selectedcategorie]);

    if(optionsState.length < 2){
        return el('span');
    }

    return   el(
        customselectcontrol,{
            label:'Select the primary category',
            options:optionsState,
            value: optionsState.find( ( option ) => option.value === PrimaryCategoryState ),
            onChange:(s)=>{   SetPrimaryCategoryState(s.selectedItem.value); console.log(PrimaryCategoryState)}
        }
    );

}
const PrimaryCategoryMeta = withSelect((select) => ({
    meta: select('core/editor').getEditedPostAttribute('meta'),
}));

const SetPrimaryCategory = withDispatch((dispatch) => ({
    SetPrimaryCategory: (metaValue) => {
        dispatch('core/editor').editPost({
            meta: {
                primary_category: metaValue,
            },
        });
    }
}));
const PrimaryCategory = compose(
    PrimaryCategoryMeta,
    SetPrimaryCategory

)(PrimaryCategoryPlugin);

function customizeCategoryBox( OriginalComponent ) {
    return function ( props ) {

        if( 'category' === props.slug ){
            return el(
                'div',
                { className: 'className' },
                el( OriginalComponent, props ),
                el(PrimaryCategory ,{selectedcategorie:props.terms})
            );
        } else {
            return  el( OriginalComponent, props )
        }


    };
}

wp.hooks.addFilter(
    'editor.PostTaxonomyType',
    'primary-category-plugin',
     customizeCategoryBox

);